<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <title>{{ $title }}</title>
    <style>
        body { font-family: Arial, sans-serif; font-size: 12px; }
        .header { margin-bottom: 20px; }
        .header h1 { font-size: 18px; margin: 0; }
        .header p { margin: 4px 0 0; }
        table { width: 100%; border-collapse: collapse; margin-top: 15px; }
        th, td { border: 1px solid #ddd; padding: 8px; }
        th { background: #f4f4f4; text-align: left; }
        tbody tr:nth-child(even) { background: #fafafa; }
    </style>
</head>
<body>
    <div class="header">
        <h1>{{ $title }}</h1>
        <p>{{ $subtitle }}</p>
    </div>
    <table>
        <thead>
            <tr>
                @foreach($headers as $header)
                    <th>{{ $header }}</th>
                @endforeach
            </tr>
        </thead>
        <tbody>
            @foreach($linhas as $linha)
                <tr>
                    @foreach($linha as $cell)
                        <td>{{ $cell }}</td>
                    @endforeach
                </tr>
            @endforeach
            @if(count($linhas) === 0)
                <tr>
                    <td colspan="{{ count($headers) }}" style="text-align:center;">Nenhum registro encontrado.</td>
                </tr>
            @endif
        </tbody>
    </table>
</body>
</html>
