<x-filament-panels::page
    @class([
        'fi-resource-list-records-page'
    ])
>
    <link href="https://unpkg.com/filepond@^4/dist/filepond.css" rel="stylesheet" />
    <script src="https://unpkg.com/filepond@^4/dist/filepond.js"></script>
    <style>.filepond--credits{ display: none; }</style>
    <input type="file" id="filePond">

    <script>
        const input = document.getElementById('filePond');
        if (!input) {
            console.error('Input not found');
        } else {
            FilePond.setOptions({
                server: {
                    url: '{{ config('filepond.server.url') }}',
                    headers: {
                        'X-CSRF-TOKEN': '{{ @csrf_token() }}',
                    }
                }
            });
            pond = FilePond.create(input, {
                chunkUploads: true
            });

        }
    </script>

    {{ $this->table }}
</x-filament-panels::page>
