<?php

namespace App\Http\Controllers;

use App\Takwim_sekolah;
use App\User;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Carbon\CarbonPeriod;
use Carbon\CarbonImmutable;
use Illuminate\Support\Arr;
class TakwimSekolahController extends Controller
{

    public function getMonthDetail($dateRange, $group)
    {
        $weekdays=[];
        $weekends=[];
        if($group == '1'){
            $start = 'Sunday';
            $end = 'Saturday';
        }else{
            $start = 'Saturday';
            $end = 'Friday';
        }

        $month =$dateRange[0]->format('m');
        $year =$dateRange[0]->format('Y');

        $cutisekolah = Takwim_sekolah::where(function($a) use ($month, $year){
            $a->whereMonth('tarikh_mula', $month)->whereYear('tarikh_mula', $year);
        })->orWhere(function($a) use ($month, $year){
            $a->whereMonth('tarikh_tamat', $month)->whereYear('tarikh_tamat', $year);
        })->get();

        $publicHolidays=[];
        foreach ($cutisekolah as $key => $cuti) {
            $dateRangeCuti = CarbonPeriod::create($cuti->tarikh_mula, $cuti->tarikh_tamat);
            array_push($publicHolidays,$dateRangeCuti->toArray());
        }

        $publicHolidays = Arr::flatten($publicHolidays);

        foreach ($dateRange as $key => $date) {
            if($date->format('l')==$start || $date->format('l')==$end){
                array_push($weekends,$date);
            }else{
                array_push($weekdays,$date);
            }
        }

        $getRedundant = array_unique( array_merge($weekends, $publicHolidays) );
        $publicHolidaysCleaned = array_diff($getRedundant, $weekends);
        $weekdays = array_diff($weekdays, $publicHolidaysCleaned);
        
        $dates = collect(['weekdays'=>$weekdays,'weekends'=>$weekends,'publicHolidays'=>$publicHolidaysCleaned]);
        return $dates;
    }

    public function index(Request $request,$month='',$year='')
    {

        for ($m=1; $m<=12; $m++) {
            $monthsOfYear[] = date('F', mktime(0,0,0,$m, 1, date('Y')));
        }
        // dd($monthsOfYear);
        $startOfMonth=CarbonImmutable::now()->startOfMonth();
        $endOfMonth= CarbonImmutable::now()->endOfMonth();
        if($month!=''&& $year!='' ){
            $startOfMonth=CarbonImmutable::createFromFormat('Y-m-d H:i:s', $year.'-'.$month.'-1 00:00:00');
            $endOfMonth=$startOfMonth->endOfMonth();
        }

        $dateRange = CarbonPeriod::create($startOfMonth, $endOfMonth);
        $monthCal='';
        foreach ($dateRange as $key => $date) {
            $monthCal.='<td>'.$date->format('d').'</td>';
        }
        $monthCal.='<td>Total</td>';
        $datesOfMonth = $this->getMonthDetail($dateRange->toArray(),'1');
        $students = User::with('tidakhadir')->where('id','<',30)->get();


        $attendances='';
        foreach ($students as $key => $student) {
            $attendances .= '<tr>';
            $attendances.='<td>'.$student->name.'</td>';
            $pelajartidakhadir = 0;
            foreach ($dateRange->toArray() as $key => $date) {
                if(in_array($date,$datesOfMonth['weekends'])){
                    $attendances.='<td style="background-color:#00F;"></td>';
                }
                elseif(in_array($date,$datesOfMonth['publicHolidays'])){
                    $attendances.='<td style="background-color:#0F6;"></td>';
                }
                else{
                    if($student->tidakhadir->where('tarikh',$date->format('Y-m-d'))->first()){
                        $attendances.='<td style="background-color:#F00;">0</td>';
                        $pelajartidakhadir++;
                    }else{
                        $attendances.='<td>1</td>';
                    }
                }
            }
            $jumlahHadir = sizeOf($datesOfMonth['weekdays'])-$pelajartidakhadir;
            $attendances.='<td>'.$jumlahHadir.'/'.sizeOf($datesOfMonth['weekdays']).'</td>';
            $attendances .= '</tr>';
        }

        $table = '<table class="table calfonts">'.
            '<tr>'.
                '<td width="20%">Name</td>'.
                $monthCal.
                $attendances.
            '</tr>'.
        '</table>';

        if($request->ajax()){
            $data['table']=$table;
            return response()->json($data);
        }

        return view('takwim.index',compact('monthsOfYear','dateRange','datesOfMonth','monthCal','attendances','table'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Takwim_sekolah  $takwim_sekolah
     * @return \Illuminate\Http\Response
     */
    public function show(Takwim_sekolah $takwim_sekolah)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Takwim_sekolah  $takwim_sekolah
     * @return \Illuminate\Http\Response
     */
    public function edit(Takwim_sekolah $takwim_sekolah)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Takwim_sekolah  $takwim_sekolah
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Takwim_sekolah $takwim_sekolah)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Takwim_sekolah  $takwim_sekolah
     * @return \Illuminate\Http\Response
     */
    public function destroy(Takwim_sekolah $takwim_sekolah)
    {
        //
    }
}
