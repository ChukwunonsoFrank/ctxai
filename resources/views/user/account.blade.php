@extends('user.layout.layout')


@section('content')
<div class="bg-[#242533] w-full h-screen mt-4">
    <div class="flex items-center container md:max-w-full mx-auto px-4 md:px-8 lg:pl-28 h-16 border-b-2 border-b-[#2A2B39]">
        <div>
            <h1 class="text-[#FFFFFF] text-xl font-bold">Settings</h1>
        </div>
    </div>
    <div class="container mx-auto px-4 lg:pl-28">
        <div class="mt-6">
            <label for="deposit_amount" class="text-[#FFFFFF] text-xs block mb-3 font-normal">Email address</label>
            <input type="email" value="{{ $user['email'] }}"
                class="w-full border-2 border-[#2A2B39] px-4 py-2 bg-[#1F202B] rounded-md text-[#FFFFFF] focus:outline focus:outline-2 focus:outline-[#28949B]" disabled>
        </div>

        <form method="post" action="{{ url('user/profile') }}">
            @csrf
            <div class="mt-6">
                <label for="password" class="text-[#FFFFFF] text-xs block mb-3 font-normal">Current password</label>
                <input type="password" id="current_password" name="current_password" value=""
                    class="w-full border-2 border-[#2A2B39] px-4 py-2 bg-[#1F202B] rounded-md text-[#FFFFFF] focus:outline focus:outline-2 focus:outline-[#28949B]">
                    <h6 id="check_password"></h6>
            </div>

            <div class="mt-6">
                <label for="password" class="text-[#FFFFFF] text-xs block mb-3 font-normal">New password</label>
                <input type="password" name="new_password" value=""
                    class="w-full border-2 border-[#2A2B39] px-4 py-2 bg-[#1F202B] rounded-md text-[#FFFFFF] focus:outline focus:outline-2 focus:outline-[#28949B]" required>
            </div>

            <div class="mt-6">
                <label for="password" class="text-[#FFFFFF] text-xs block mb-3 font-normal">Confirm new password</label>
                <input type="password" name="confirm_password" value=""
                    class="w-full border-2 border-[#2A2B39] px-4 py-2 bg-[#1F202B] rounded-md text-[#FFFFFF] focus:outline focus:outline-2 focus:outline-[#28949B]" required>
            </div>
            <input type="hidden" name="action" value="password">
            <div class="mt-6 text-center">
                <input type="submit" class="bg-[#40ffdd] rounded-lg py-3 px-2 w-full text-[#000000] text-sm font-bold"
                                        value="Update password" required aria-label="amount">
            </div>
        </form>
    </div>
</div>
@endsection

@section('footer')
    <script>
        $(document).ready(function() {
            $("#current_password").keyup(function() {
                var current_password = $("#current_password").val();

                if (current_password == "") {
                    $('#check_password').html("")
                } else {
                    $.ajax({
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        },
                        type: 'POST',
                        url: '/user/check-current-password',
                        data: {
                            current_password: current_password
                        },
                        success: function(resp) {
                            if (resp == "true") {
                                $('#check_password').html(
                                    "<b style='color:green;'>Password is correct</b>")
                            } else if (resp == "false") {
                                $('#check_password').html(
                                    "<b style='color:red;'>Password is wrong</b>")
                            }
                        },
                        error: function(xhr, status, error) {
                            var err = eval("(" + xhr.responseText + ")");
                            alert(err.Message);
                        }
                    });
                }
            })
        })
    </script>
@endsection
