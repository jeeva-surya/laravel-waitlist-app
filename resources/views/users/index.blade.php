@extends('users.layout')
 
@section('content')
   
    <div class="col-md-12">
        @if ($message = Session::get('success'))
            <div class="alert alert-success mb-1">
                <p>{{ $message }}</p>
            </div>
        @endif
        <div class="row">
        <div class="col-lg-12 margin-tb mb-1">
            <div class="pull-left">
                <h2>User Management</h2>
            </div>
            <div class="pull-right">
                <a class="btn btn-success rounded" href="{{ route('users.create') }}"> Create New User</a>
            </div>
        </div>
        </div>    
        <table class="table bg-white">
        <thead class="table-dark">
          <tr>
            <th scope="col">S.No</th>
            <th scope="col">Name</th>
            <th scope="col">Email</th>
            <th scope="col">Referrer</th>
            <th scope="col">Waitlist Position</th>
            <th scope="col">Actions</th>
          </tr>
        </thead>
        <tbody>
            @if($users->isEmpty())
            <tr>
                        <td colspan="7" style="text-align: center;">No results</td>
                    </tr>
                    @else
                    
                    @foreach ($users as $user)
                
                    <tr>
                        <td>{{ ++$i }}</td>
                        <td>{{ $user->name }}</td>
                        <td>{{ $user->email }}</td>
                        <td>{{ $user->referrer->name ?? 'Not Specified' }}</td>
                        <td>{{ $user->position }}</td>
                        <td>
                            <form action="{{ route('users.destroy',$user->id) }}" method="POST">
               
                                <a class="btn btn-primary btn-sm" href="{{ route('users.show',$user->id) }}"><i class="zmdi zmdi-eye "></i></a>
                
                                <a class="btn btn-success btn-sm" href="{{ route('users.edit',$user->id) }}"><i class="zmdi zmdi-edit"></i></a>
               
                                @csrf
                                @method('DELETE')
                  
                                <button type="submit" onclick="return confirm('are you sure?')" class="btn btn-danger btn-sm"><i class="zmdi zmdi-delete"></i></button>
                            </form>
                        </td>
                    </tr>
                    @endforeach
                    @endif
        </tbody>
    </table>
    {!! $users->links() !!}
      
@section('script')
<script type="text/javascript">
    $(document).ready(function(){
        $('#resetbtn').click(function(){
            $("#location").val('');
            $("#name").val('');
            $("#email").val('');
            $("#fromdate").val('');
            $("#todate").val('');
            $("#myForm").submit();
        });
        /*$("html, body").animate({ scrollTop: 1000 }, "slow");*/

        
    });
</script>
@endsection

@endsection