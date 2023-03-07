<style>
    * {
        font-family: monospace;
    }
</style>
<h3>Hola, administrador.</h3>
<p>Se ha creado un nuevo usuario. Este es el resumen de registros por paises:</p>
<br>
<table>
    <thead>
        <th>Pais</th>
        <th>Total</th>
    </thead>
    <tbody>
        @foreach ($countriesAndTotal as $item)
            <tr>
                <td> {{ $item->country }}</td>
                <td> {{ $item->total }}</td>
            </tr>
        @endforeach
    </tbody>
</table>