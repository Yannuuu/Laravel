<x-layouts.app :tittle="__('Posts')">
    <h1>posts halo</h1>
    

    @if (session('succes'))
        <div class="alert alert-success">
            {{ session('succes') }}
        </div>
    @endif

    <table>
        <head>
            <tr>
                <th>Tittle</th>
                <th>Content</th>
                <th>Created</th>
                <th>Updated At</th>
            </tr>
        </head>
    </table>
</x-layouts.app>