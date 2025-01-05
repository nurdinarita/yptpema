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
                        <a href="{{ url('admin/blog/'.$blog->id.'/edit') }}" class="btn btn-warning btn-sm">
                            <i class="fas fa-edit" style="margin-right: 4px;"></i>
                            Edit
                        </a>
                        <a>
                            <form action="{{ url('admin/blog/'.$blog->id) }}" method="POST" style="display: inline;">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Are you sure?')">
                                    <i class="fas fa-trash" style="margin-right: 4px;"></i>
                                    Delete
                                </button>
                            </form>
                        </a>
                    </div>
                </div>
            </div>
            <div class="card-body">
                <h3>{{ $blog->title }}</h3>
                <hr>
                <img src="{{ asset($blog->image) }}" alt="{{ $blog->title }}" class="img-fluid" style="display: block; margin: 0 auto; margin-bottom: 20px; max-height: 400px;">
                <p class="card-text">{!! $blog->body !!}</p>
            </div>
            <div class="card-footer text-muted">
                <small>Published on {{ $blog->created_at->format('d M Y') }} by {{ $blog->author->name }}</small>
            </div>
        </div>
    </div>
</div>
@endsection