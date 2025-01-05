@extends('admin.layouts.app')

@section('content')
<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="card-header">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <a href="{{ url('admin/blog/create') }}" class="btn btn-primary btn-sm">
                            <i class="fas fa-plus-square" style="margin-right: 4px;"></i>
                            Add New
                        </a>
                    </div>
                    <div style="max-width: 300px;">
                        <input type="search" id="search" class="form-control form-control-sm" placeholder="Search...">
                    </div>
                </div>
            </div>
            <div class="card-body">
                @if(session('success'))
                    <div class="alert alert-success">{{ session('success') }}</div>
                @endif
                {{-- {{ $blogs }} --}}
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Title</th>
                            <th>Author</th>
                            <th>Created At</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($blogs as $blog)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $blog->title }}</td>
                            <td>{{ $blog->author->name }}</td>
                            <td>{{ $blog->created_at->format('d M Y') }}</td>
                            <td>
                                <a href="{{ url('admin/blog/'.$blog->id) }}" class="btn btn-info btn-sm">Show</a>
                                <a href="{{ url('admin/blog/'.$blog->id.'/edit') }}" class="btn btn-warning btn-sm">Edit</a>
                                <form action="{{ url('admin/blog/'.$blog->id) }}" method="POST" style="display: inline;">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Are you sure?')">Delete</button>
                                </form>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
        </div>
    </div>
</div>
@endsection

@section('scripts')

<script>
    $('#search').on('keyup', function() {
        console.log($(this).val());
        let value = $(this).val();
        $.ajax({
            type: 'get',
            url: '{{ url('admin/blog') }}?search='+value,
            success: function(res) {
                // $('tbody').html(data);
                console.log(res);
            }
        });
    });
</script>   
@endsection