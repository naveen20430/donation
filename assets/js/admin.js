/**
 * Admin Panel JavaScript
 */

document.addEventListener('DOMContentLoaded', function() {
    // Auto-hide alerts
    const alerts = document.querySelectorAll('.alert');
    alerts.forEach(alert => {
        setTimeout(() => {
            const bsAlert = new bootstrap.Alert(alert);
            if (bsAlert) {
                bsAlert.close();
            }
        }, 5000);
    });

    // Confirm delete actions
    const deleteLinks = document.querySelectorAll('a[href*="delete"], a[href*="reject"]');
    deleteLinks.forEach(link => {
        link.addEventListener('click', function(e) {
            if (!confirm('Are you sure you want to perform this action?')) {
                e.preventDefault();
            }
        });
    });

    // Form validation
    const forms = document.querySelectorAll('form');
    forms.forEach(form => {
        form.addEventListener('submit', function(e) {
            if (!form.checkValidity()) {
                e.preventDefault();
                e.stopPropagation();
            }
            form.classList.add('was-validated');
        });
    });

    // Image preview for file inputs
    const imageInputs = document.querySelectorAll('input[type="file"][accept*="image"]');
    imageInputs.forEach(input => {
        input.addEventListener('change', function(e) {
            const file = e.target.files[0];
            if (file) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    // Create or update preview
                    let preview = input.parentElement.querySelector('.image-preview');
                    if (!preview) {
                        preview = document.createElement('img');
                        preview.className = 'image-preview img-thumbnail mt-2';
                        preview.style.maxWidth = '300px';
                        input.parentElement.appendChild(preview);
                    }
                    preview.src = e.target.result;
                };
                reader.readAsDataURL(file);
            }
        });
    });

    // Filter form auto-submit on change (optional)
    const filterSelects = document.querySelectorAll('select[name="campaign"], select[name="status"]');
    // Uncomment if you want auto-submit on filter change
    // filterSelects.forEach(select => {
    //     select.addEventListener('change', function() {
    //         this.form.submit();
    //     });
    // });
});

// Export function for CSV download
function exportToCSV() {
    // This is handled server-side, but you can add client-side logic here if needed
    return true;
}

