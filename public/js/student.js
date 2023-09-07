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
    // delete
    const deleteBtn = document.querySelector('.list');
    deleteBtn.addEventListener('click', (event)=>{
        event.preventDefault();
        if(event.target.classList.contains('delete')) {
            Swal.fire({
                title: 'Are you sure?',
                text: 'Data will be deleted.',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonText: 'Yes, continue!',
                cancelButtonText: 'Cancel'
            }).then((result) => {
                if (result.isConfirmed) {
                    window.location.href = event.target.href;
                }
            });
        } else if(event.target.classList.contains('edit')) {
            window.location.href = event.target.href;
        }
    });
});