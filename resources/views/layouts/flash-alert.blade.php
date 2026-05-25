@if(session('success'))
<script>
    document.addEventListener('DOMContentLoaded', function() {
        Swal.fire({
            title: 'Berhasil!',
            text: '{{ session("success") }}',
            icon: 'success',
            timer: 2500,
            timerProgressBar: true,
            showConfirmButton: false,
            background: 'rgba(15, 23, 42, 0.95)',
            color: '#e2e8f0',
            iconColor: '#22c55e',
            customClass: { popup: 'swal-glassmorphism' }
        });
    });
</script>
@endif

@if(session('error'))
<script>
    document.addEventListener('DOMContentLoaded', function() {
        Swal.fire({
            title: 'Gagal!',
            text: '{{ session("error") }}',
            icon: 'error',
            confirmButtonColor: '#3b82f6',
            background: 'rgba(15, 23, 42, 0.95)',
            color: '#e2e8f0',
            customClass: { popup: 'swal-glassmorphism' }
        });
    });
</script>
@endif

@if(session('warning'))
<script>
    document.addEventListener('DOMContentLoaded', function() {
        Swal.fire({
            title: 'Perhatian!',
            text: '{{ session("warning") }}',
            icon: 'warning',
            confirmButtonColor: '#f59e0b',
            background: 'rgba(15, 23, 42, 0.95)',
            color: '#e2e8f0',
            customClass: { popup: 'swal-glassmorphism' }
        });
    });
</script>
@endif

@if($errors->any())
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            Swal.fire({
                title: 'Validasi Gagal!',
                html: `<ul class="text-start mb-0">
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>`,
                icon: 'error',
                confirmButtonColor: '#3b82f6',
                background: 'rgba(15, 23, 42, 0.95)',
                color: '#e2e8f0',
                customClass: { popup: 'swal-glassmorphism' }
            });
        });
    </script>
@endif