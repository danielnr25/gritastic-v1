@extends('layouts.admin')

@section('content')
<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h3 class="m-2" style="font-size: 1.8rem;color:#000006;">Agregar Categoria</h3>
            </div>
            <div class="col-sm-6">
            <a href="{{ route('admin.categories.index') }}" class="btn btn-primary float-right" style="background: #4338ca;">
                Regresar
            </a>
            </div>
        </div>
    </div>
</div>
        <div class="card">
            <div class="card-body">
                <form action="{{ route('admin.categories.store') }}" method="post">
                    @csrf
                    <div class="form-group">
                        <label for="name">Nombre de la categoria</label>
                        <input type="text" name="name" class="form-control">
                    </div>
                    <div class="form-group {{ $errors->has('photo') ? 'has-error' : '' }}">
                        <label for="photo">Imagen</label>
                        <div class="needsclick dropzone" id="photo-dropzone">

                        </div>
                        @if($errors->has('photo'))
                            <em class="invalid-feedback">
                                {{ $errors->first('photo') }}
                            </em>
                        @endif
                    </div>
<!--                     <div class="form-group">
                        <label for="parent">Parent</label>
                        <select name="category_id" class="form-control">
                            <option value="">-- Default --</option>
                            @foreach($categories as $id => $categoryName)
                                <option value="{{ $id }}">{{ $categoryName }}</option>
                            @endforeach
                        </select>
                    </div> -->
                    <div class="form-group">
                        <button type="submit" class="btn btn-primary">Guardar</button>
                    </div>
                </form>
            </div>
@endsection

@push('style-alt')
<link rel="stylesheet" href="https://unpkg.com/dropzone@5/dist/min/dropzone.min.css" type="text/css" />
@endpush

@push('script-alt')
<script src="https://unpkg.com/dropzone@5/dist/min/dropzone.min.js"></script>
    <script>
    Dropzone.options.photoDropzone = {
            url: "{{ route('admin.categories.storeImage') }}",
            acceptedFiles: '.jpeg,.jpg,.png,.gif',
            maxFiles: 1,
            addRemoveLinks: true,
        headers: {
            'X-CSRF-TOKEN': "{{ csrf_token() }}"
        },
        success: function (file, response) {
            $('form').find('input[name="photo"]').remove()
            $('form').append('<input type="hidden" name="photo" value="' + response.name + '">')
        },
        removedfile: function (file) {
            file.previewElement.remove()
            if (file.status !== 'error') {
                $('form').find('input[name="photo"]').remove()
                this.options.maxFiles = this.options.maxFiles + 1
            }
        },
        init: function () {
            @if(isset($category) && $category->photo)
                var file = {!! json_encode($category->photo) !!}
                    this.options.addedfile.call(this, file)
                this.options.thumbnail.call(this, file, "{{ $category->photo->getUrl() }}")
                file.previewElement.classList.add('dz-complete')
                $('form').append('<input type="hidden" name="photo" value="' + file.file_name + '">')
                this.options.maxFiles = this.options.maxFiles - 1
            @endif
        },
        error: function (file, response) {
            if ($.type(response) === 'string') {
                var message = response //dropzone sends it's own error messages in string
            } else {
                var message = response.errors.file
            }
            file.previewElement.classList.add('dz-error')
            _ref = file.previewElement.querySelectorAll('[data-dz-errormessage]')
            _results = []
            for (_i = 0, _len = _ref.length; _i < _len; _i++) {
                node = _ref[_i]
                _results.push(node.textContent = message)
            }
            return _results
        }
    }
</script>
@endpush
