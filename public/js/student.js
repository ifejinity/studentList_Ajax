document.addEventListener('DOMContentLoaded', function () {
    // logout
    const logoutLink = document.getElementById('logout');
    logoutLink.addEventListener('click', function (e) {
        e.preventDefault();
        
        Swal.fire({
            title: 'Are you sure?',
            text: 'You will be logged out.',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonText: 'Yes, log me out!',
            cancelButtonText: 'Cancel'
        }).then((result) => {
            if (result.isConfirmed) {
                window.location.href = logoutLink.href;
            }
        });
    });
});