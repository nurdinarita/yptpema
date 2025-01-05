@extends('admin.layouts.app')

@section('content')
<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="card-header">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <a href="{{ url('admin/blog') }}" class="btn btn-secondary btn-sm">
                            <i class="fas fa-arrow-left" style="margin-right: 4px;"></i>
                            Back
                        </a>
                    </div>
                    <div>
                        <h3>Create Blog</h3>
                    </div>
                </div>
            </div>
            <div class="card-body">
                <form action="{{ !isset($blog) ? url('admin/blog') : url('admin/blog/'.$blog->id) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @if(isset($blog))
                        @method('PUT')
                    @endif
                    <div class="form-group">
                        <label for="title">Title</label>
                        <input type="text" name="title" id="title" placeholder="Title" class="form-control @error('title') is-invalid @enderror" value="{{ isset($blog) ? $blog->title : old('title') }}" required>
                        @error('title')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="image">Image</label>
                        <input type="file" name="image" id="image" class="form-control @error('image') is-invalid @enderror" {{ isset($blog) ? '' : 'required' }}>
                    </div>
                    <div class="form-group">
                        <label for="body">Body</label>
                        <textarea id="body" name="body" required>{{ isset($blog) ? $blog->body : old('body') }}</textarea>
                        {{-- <textarea name="body" id="body" class="form-control @error('body') is-invalid @enderror">{{ old('body') }}</textarea> --}}
                        @error('body')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <button type="submit" class="btn btn-primary">Save</button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
    $('#body').summernote({
        placeholder: 'Write your blog content here...',
        tabsize: 2,
        height: 300
    });
</script>
@endsection