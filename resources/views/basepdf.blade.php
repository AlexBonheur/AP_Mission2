<div id="contenu">
    <table>
        <tr>
            <th>Etape:</th>
            <th>Frais Kilométré</th>
            <th>Etape</th>
            <th>Repas Midi</th>
        </tr>

        <tr>@foreach($ligne as $unligne)</tr>
        <tr>
            <th>{{$unligne['ETP']}}</th>
            <th>{{$unligne['KM']}}</th>
            <th>{{$unligne['ETP']}}</th>
            <th>{{$unligne['REP']}}</th>
        </tr>
        @endforeach
    </table>
</div>