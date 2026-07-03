@extends('layouts.admin')

@section('title', 'Quản lý người dùng')
@section('content')

    <!-- page content -->
    <div class="right_col" role="main">
        <div class="">
            <div class="page-title">
                <div class="title_left">
                    <h3>Quản lý người dùng</h3>
                </div>
            </div>

            <div class="clearfix"></div>


            <div class="x_panel">
                <div class="x_content">

                    <div class="row" id="usersContainer">
                        @foreach ($users as $user)
                            <div class="col-md-4 col-sm-4 profile_details user-card" data-user-id="{{ $user->id }}">
                                <div class="well profile_view">
                                    <div class="col-sm-12">
                                        <h4 class="brief text-uppercase"><i>{{ $user->role->name }}</i></h4>
                                        <div class="left col-md-7 col-sm-7">
                                            <h2>{{ $user->name }}</h2>
                                            <p><strong>Email: </strong> {{ $user->email }} </p>
                                            <ul class="list-unstyled">
                                                <li><i class="fa fa-phone"></i> SDT: {{ $user->phone_number }}</li>
                                            </ul>
                                        </div>
                                        <div class="right col-md-5 col-sm-5 text-center">
                                            <img src="{{ asset('storage/' . ($user->avatar ?? 'uploads/users/defult-avatar.png')) }}"
                                                alt="" class="img-circle img-fluid">
                                        </div>
                                    </div>
                                    <div class=" profile-bottom text-center">
                                        <div class=" col-sm-12 emphasis">
                                            @if ($user->role->name == "customer")
                                                <button type="button" class="btn btn-primary btn-sm upgradeStaff"
                                                    data-userid="{{ $user->id }}">
                                                    <i class="fa fa-user"> </i> Nhân viên
                                                </button>
                                                @if ($user->status == "banned")
                                                    <button type="button" class="btn btn-success btn-sm changeStatus"
                                                        data-userid="{{ $user->id }} " data-status="active">
                                                        <i class="fa fa-check"> </i> Bỏ chặn
                                                    </button>
                                                @else
                                                    <button type="button" class="btn btn-warning btn-sm changeStatus"
                                                        data-userid="{{ $user->id }} " data-status="banned">
                                                        <i class="fa fa-ban"> </i> Chặn
                                                    </button>
                                                @endif

                                                @if ($user->status == "deleted")
                                                    <button type="button" class="btn btn-success btn-sm changeStatus"
                                                        data-userid="{{ $user->id }} " data-status="active">
                                                        <i class="fa fa-undo"> </i> Khôi phục
                                                    </button>
                                                @else
                                                    <button type="button" class="btn btn-danger btn-sm changeStatus"
                                                        data-userid="{{ $user->id }} " data-status="deleted">
                                                        <i class="fa fa-trash"> </i> Xóa
                                                    </button>
                                                @endif
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>

                    <div class="text-center" id="loadingIndicator" style="display: none; padding: 20px;">
                        <i class="fa fa-spinner fa-spin"></i> Đang tải...
                    </div>
                </div>
            </div>

            <script>
                let nextPage = 2;
                let isLoading = false;
                let hasMore = {{ $users->hasMorePages() ? 'true' : 'false' }};

                function loadMoreUsers() {
                    if (isLoading || !hasMore) return;

                    isLoading = true;
                    $('#loadingIndicator').show();

                    $.ajax({
                        url: '{{ route("admin.users.index") }}',
                        type: 'GET',
                        data: { page: nextPage },
                        success: function (response) {
                            response.users.forEach(function (user) {
                                const userCard = `
                                    <div class="col-md-4 col-sm-4 profile_details user-card" data-user-id="${user.id}">
                                        <div class="well profile_view">
                                            <div class="col-sm-12">
                                                <h4 class="brief text-uppercase"><i>${user.role.name}</i></h4>
                                                <div class="left col-md-7 col-sm-7">
                                                    <h2>${user.name}</h2>
                                                    <p><strong>Email: </strong> ${user.email} </p>
                                                    <ul class="list-unstyled">
                                                        <li><i class="fa fa-phone"></i> SDT: ${user.phone_number}</li>
                                                    </ul>
                                                </div>
                                                <div class="right col-md-5 col-sm-5 text-center">
                                                    <img src="/storage/${user.avatar || 'uploads/users/defult-avatar.png'}"
                                                        alt="" class="img-circle img-fluid">
                                                </div>
                                            </div>
                                            <div class=" profile-bottom text-center">
                                                <div class=" col-sm-12 emphasis">
                                                    ${user.role.name === 'customer' ? `
                                                        <button type="button" class="btn btn-primary btn-sm upgradeStaff"
                                                            data-userid="${user.id}">
                                                            <i class="fa fa-user"> </i> Nhân viên
                                                        </button>
                                                        <button type="button" class="btn btn-warning btn-sm changeStatus"
                                                            data-userid="${user.id}" data-status="${user.status === 'banned' ? 'active' : 'banned'}">
                                                            <i class="fa fa-${user.status === 'banned' ? 'check' : 'ban'}"> </i> ${user.status === 'banned' ? 'Bỏ chặn' : 'Chặn'}
                                                        </button>
                                                        <button type="button" class="btn btn-danger btn-sm changeStatus"
                                                            data-userid="${user.id}" data-status="${user.status === 'deleted' ? 'active' : 'deleted'}">
                                                            <i class="fa fa-${user.status === 'deleted' ? 'undo' : 'trash'}"> </i> ${user.status === 'deleted' ? 'Khôi phục' : 'Xóa'}
                                                        </button>
                                                    ` : ''}
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                `;
                                $('#usersContainer').append(userCard);
                            });

                            nextPage = response.next_page;
                            hasMore = response.has_more;
                            isLoading = false;
                            $('#loadingIndicator').hide();
                        },
                        error: function () {
                            isLoading = false;
                            $('#loadingIndicator').hide();
                        }
                    });
                }

                $(window).on('scroll', function () {
                    if (($(window).scrollTop() + $(window).height()) >= ($(document).height() - 100)) {
                        loadMoreUsers();
                    }
                });
            </script>
        </div>
    </div>
    <!-- /page content -->

@endsection