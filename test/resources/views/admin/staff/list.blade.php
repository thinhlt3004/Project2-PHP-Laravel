@extends('admin_layout')
@section('admin_content')
    <div id="content-wrapper">
        <div class="container-fluid">
            <!-- Breadcrumbs-->
            <ol class="breadcrumb">
                <li class="breadcrumb-item">
                    <a href="{{ route('admin.dashboard.index') }}">Admin</a>
                </li>
                <li class="breadcrumb-item">
                    <a href="{{ route('admin.staff.index') }}">Staff</a>
                </li>
                <li class="breadcrumb-item active">List</li>
            </ol>
            @include('errors.message')
            <!-- DataTables Example -->
            <div class="action-bar">
                <a href="{{ route('admin.staff.create') }}" class="btn btn-primary btn-sm" >Add Employee</a>
                <input type="submit" class="btn btn-danger btn-sm" value="Xóa" name="delete">
            </div>
            <div class="card mb-3">
                <div class="card-header">
                    <i class="fas fa-users"></i>
                    Staff Management 
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-hover" id="dataTable-3" width="100%" cellspacing="0">
                            <thead>
                                <tr>
                                    <th class="filter-input">Staff Id</th>
                                    <th class="filter-input">Name </th>
                                    <th class="filter-input">Address </th>
                                    <th class="filter-input">Email </th>
                                    <th class="filter-input">Mobile </th>
                                    <th class="filter-select">Active </th>
                                    <th></th>
                                    <th></th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($staff_users as $user)
                                    <tr>
                                        <td>{{ $user->id }}</td>
                                        <td>{{ $user->name }}</td>
                                        <td>{{ $user->housenumber_street ?? "" }} , {{ $user->ward->name ?? "" }} , {{ $user->ward->district->name ?? "" }} , {{ $user->ward->district->province->name ?? "" }}</td>
                                        <td>{{ $user->email }}</td>
                                        <td>{{ $user->mobile  ?? ""}}</td>
                                        <td>{{ $user->is_active == true ? "Yes" : "No" }}</td>
                                        <td> <a type="button" href="{{ route('admin.staff.edit' , ['staff' => $user->id]) }}"
                                                class="btn btn-warning btn-sm">Edit</a></td>
                                        <td><input type="button" onclick="Delete('1');" value="Xóa"
                                                class="btn btn-danger btn-sm"></td>
                                    </tr>
                                @endforeach
                            </tbody>
                            <tfoot>
                                <th></th>
                                <th></th>
                                <th></th>
                                <th></th>
                                <th></th>
                                <th></th>
                                <th></th>
                                <th></th>
                            </tfoot>
                        </table>
                    </div>
                </div>
            </div>

            {{-- Full Calendar  --}}
            <div class="card mb-3">
                <div class="card-header">
                    <i class="fas fa-calendar"></i>
                    Calendar 
                </div>
                <div class="card-body">
                    <div id="calendar" data-url="{{ url('admin/staff/calendar/action') }}"></div>
                </div>
            </div>
        </div>
        <!-- /.container-fluid -->
        <!-- Sticky Footer -->
        @include('admin.footer')
    </div>
@endsection

@section('scripts')
<script>

    $(document).ready(function () {
        var url = $('#calendar').data('url');
        $.ajaxSetup({
            headers:{
                'X-CSRF-TOKEN' : $('meta[name="csrf-token"]').attr('content')
            }
        });
    
        var calendar = $('#calendar').fullCalendar({
            editable:true,
            header:{
                left:'prev,next today',
                center:'title',
                right:'month,agendaWeek,agendaDay'
            },
            events:"{{ route('admin.staff.index') }}",
            selectable:true,
            selectHelper: true,
            select:function(start, end, allDay)
            {
                var title = prompt('Event Title:');
    
                if(title)
                {
                    var start = $.fullCalendar.formatDate(start, 'Y-MM-DD HH:mm:ss');
    
                    var end = $.fullCalendar.formatDate(end, 'Y-MM-DD HH:mm:ss');
    
                    $.ajax({
                        url: url,
                        type:"POST",
                        data:{
                            title: title,
                            start: start,
                            end: end,
                            type: 'add'
                        },
                        success:function(data)
                        {
                            calendar.fullCalendar('refetchEvents');
                            // alert("Event Created Successfully");
                            notyf.success('Event Created Successfully');
                        }
                    })
                }
            },
            editable:true,
            eventResize: function(event, delta)
            {
                var start = $.fullCalendar.formatDate(event.start, 'Y-MM-DD HH:mm:ss');
                var end = $.fullCalendar.formatDate(event.end, 'Y-MM-DD HH:mm:ss');
                var title = event.title;
                var id = event.id;
                $.ajax({
                    url: url,
                    type:"POST",
                    data:{
                        title: title,
                        start: start,
                        end: end,
                        id: id,
                        type: 'update'
                    },
                    success:function(response)
                    {
                        calendar.fullCalendar('refetchEvents');
                        // alert("Event Updated Successfully");
                        notyf.success('Event Updated Successfully');
                    }
                })
            },
            eventDrop: function(event, delta)
            {
                var start = $.fullCalendar.formatDate(event.start, 'Y-MM-DD HH:mm:ss');
                var end = $.fullCalendar.formatDate(event.end, 'Y-MM-DD HH:mm:ss');
                var title = event.title;
                var id = event.id;
                $.ajax({
                    url: url,
                    type:"POST",
                    data:{
                        title: title,
                        start: start,
                        end: end,
                        id: id,
                        type: 'update'
                    },
                    success:function(response)
                    {
                        calendar.fullCalendar('refetchEvents');
                        // alert("Event Updated Successfully");
                        notyf.success('Event Updated Successfully');
                    }
                })
            },
    
            eventClick:function(event)
            {
                if(confirm("Are you sure you want to remove it?"))
                {
                    var id = event.id;
                    $.ajax({
                        url: url,
                        type:"POST",
                        data:{
                            id:id,
                            type:"delete"
                        },
                        success:function(response)
                        {
                            calendar.fullCalendar('refetchEvents');
                            // alert("Event Deleted Successfully");
                            notyf.error('Event Deleted Successfully');
                        }
                    })
                }
            }
        });
    
    });
      
    </script>

<script>
    $(document).ready(function() {
        var table = $('#dataTable-3').DataTable({
            // flipping horizontal scroll bar in datatables refer to admin.css line 94
            order: [
                [1, "asc"]
            ],
            autoWidth: 'TRUE',
            scrollX: 'TRUE',
            lengthMenu: [
                [5, 10, 25, 50, -1],
                [5, 10, 25, 50, "All"]
            ],
            columnDefs: [{
                targets: 2,
                render: $.fn.dataTable.render.ellipsis(15, true)
            }],
        });

        //SEARCH INPUT BY COLUMNS// - put class on top of header

        table.columns('.filter-input').every(function(i) {
            var column = table.column(i);

            // Create the select list and search operation
            var input = $(`<input type='search' class='form-control form-control-sm' placeholder='Search'>`)
                .appendTo(
                    this.footer()
                )
                .on('keyup change', function() {
                    column
                        .search($(this).val())
                        .draw();
                });
        });

        //SEARCH INPUT BY COLUMNS//


        //SEARCH SELECT BY COLUMNS//

        table.columns('.filter-select').every(function(i) {
            var column = table.column(i);

            // Create the select list and search operation
            var select = $(`<select class='form-control form-control-sm'/>`)
                .appendTo(
                    this.footer()
                )
                .on('change', function() {
                    column
                        .search($(this).val())
                        .draw();
                });

            // Get the search data for the first column and add to the select list
            select.append($('<option value="">Select</option>'));
            this
                .cache('search')
                .sort()
                .unique()
                .each(function(d) {
                    select.append($('<option value="' + d + '">' + d + '</option>'));
                });
        });

        //SEARCH SELECT BY COLUMNS//

    });

</script>
@endsection
