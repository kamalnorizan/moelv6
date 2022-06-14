<table width="100%">
    <thead>
        <tr>
            <th>Name</th>
            <th>Comments</th>
            <th>Date</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($comments as $comment)
        <tr>
            <td>{{$comment->user->name}}</td>
            <td>{{$comment->content}}</td>
            <td>{{$comment->created_at}}</td>
        </tr>
        @endforeach
    </tbody>
</table>
