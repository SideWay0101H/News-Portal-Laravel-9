@extends('admin.layout.app')

@section('heading', 'Social Items')

@section('button')
<a href="{{ route('admin_social_item_create') }}" class="btn btn-primary"><i class="fas fa-plus"></i> Add </a>
@endsection

@section('main_content')
<div class="section-body">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-bordered" id="example1">
                            <thead>
                                <tr>
                                    <th>SL</th>
                                    <th>Preview</th>
                                    <th>Icon</th>
                                    <th>URL</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            @foreach($social_item_data as $row)
                            <tbody>
                                <tr>
                                    <td>{{  $loop->iteration  }}</td>
                                    <td class="{{  $row->icon }}" style="font-size: 30px;"> </td>
                                    <td>{{  $row->icon }}</td>
                                    <td>{{ $row->url}}</td>
                                    <td class="pt_10 pb_10">
                                        <a href="{{ route('admin_social_item_edit',$row->id) }}"
                                            class="btn btn-primary">Edit</a>
                                        <a href="{{ route('admin_social_item_delete',$row->id) }}" class="btn btn-danger"
                                            onClick="return confirm('Are you sure');">Delete</a>
                                    </td>
                                </tr>
                            </tbody>
                            @endforeach

                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

