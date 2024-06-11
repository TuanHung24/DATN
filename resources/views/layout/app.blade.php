@if (session('account_locked'))
    <script>
        window.onload = function() {
            alert("Tài khoản của bạn đã bị khóa.");
            window.location.href = "{{ route('login') }}";
        };
    </script>
@endif