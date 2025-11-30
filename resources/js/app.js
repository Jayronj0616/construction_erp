import './bootstrap';
import Alpine from 'alpinejs';
import Swal from 'sweetalert2';

window.Alpine = Alpine;
window.Swal = Swal;

Alpine.start();

// Global SweetAlert2 configuration
window.Toast = Swal.mixin({
    toast: true,
    position: 'top-end',
    showConfirmButton: false,
    timer: 3000,
    timerProgressBar: true,
    didOpen: (toast) => {
        toast.addEventListener('mouseenter', Swal.stopTimer)
        toast.addEventListener('mouseleave', Swal.resumeTimer)
    }
});

// Confirmation dialog helper
window.confirmDelete = function(formId) {
    Swal.fire({
        title: 'Are you sure?',
        text: "You won't be able to revert this!",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#ef4444',
        cancelButtonColor: '#6b7280',
        confirmButtonText: 'Yes, delete it!',
        cancelButtonText: 'Cancel'
    }).then((result) => {
        if (result.isConfirmed) {
            document.getElementById(formId).submit();
        }
    });
    return false;
};

// Modal helper for forms
window.openFormModal = async function(url, title, width = '800px') {
    try {
        const response = await fetch(url, {
            headers: {
                'X-Requested-With': 'XMLHttpRequest'
            }
        });
        
        if (!response.ok) throw new Error('Failed to load form');
        
        const html = await response.text();
        
        Swal.fire({
            title: title,
            html: html,
            width: width,
            showConfirmButton: false,
            showCloseButton: true,
            customClass: {
                popup: 'modal-popup',
                htmlContainer: 'modal-content'
            },
            didOpen: () => {
                // Handle form submission in modal
                const form = Swal.getHtmlContainer().querySelector('form');
                if (form) {
                    form.addEventListener('submit', async (e) => {
                        e.preventDefault();
                        
                        const submitBtn = form.querySelector('button[type="submit"]');
                        const originalText = submitBtn.innerHTML;
                        submitBtn.disabled = true;
                        submitBtn.innerHTML = '<svg class="animate-spin h-5 w-5 inline" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path></svg> Processing...';
                        
                        try {
                            const formData = new FormData(form);
                            const response = await fetch(form.action, {
                                method: form.method,
                                body: formData,
                                headers: {
                                    'X-Requested-With': 'XMLHttpRequest',
                                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                                }
                            });
                            
                            const data = await response.json();
                            
                            if (data.success) {
                                Swal.close();
                                Toast.fire({
                                    icon: 'success',
                                    title: data.message
                                });
                                
                                // Reload page after short delay
                                setTimeout(() => {
                                    window.location.reload();
                                }, 500);
                            } else {
                                // Show validation errors
                                if (data.errors) {
                                    Object.keys(data.errors).forEach(key => {
                                        const input = form.querySelector(`[name="${key}"]`);
                                        if (input) {
                                            input.classList.add('border-red-300');
                                            const errorDiv = document.createElement('p');
                                            errorDiv.className = 'mt-1 text-sm text-red-600';
                                            errorDiv.textContent = data.errors[key][0];
                                            input.parentNode.appendChild(errorDiv);
                                        }
                                    });
                                }
                                
                                submitBtn.disabled = false;
                                submitBtn.innerHTML = originalText;
                            }
                        } catch (error) {
                            console.error('Form submission error:', error);
                            submitBtn.disabled = false;
                            submitBtn.innerHTML = originalText;
                            
                            Toast.fire({
                                icon: 'error',
                                title: 'An error occurred. Please try again.'
                            });
                        }
                    });
                }
            }
        });
    } catch (error) {
        console.error('Modal load error:', error);
        Toast.fire({
            icon: 'error',
            title: 'Failed to load form'
        });
    }
};

// Quick view modal helper
window.openViewModal = async function(url, title, width = '900px') {
    try {
        const response = await fetch(url, {
            headers: {
                'X-Requested-With': 'XMLHttpRequest'
            }
        });
        
        if (!response.ok) throw new Error('Failed to load content');
        
        const html = await response.text();
        
        Swal.fire({
            title: title,
            html: html,
            width: width,
            showConfirmButton: false,
            showCloseButton: true,
            customClass: {
                popup: 'modal-popup',
                htmlContainer: 'modal-content'
            }
        });
    } catch (error) {
        console.error('Modal load error:', error);
        Toast.fire({
            icon: 'error',
            title: 'Failed to load content'
        });
    }
};

// Add loading state to forms
document.addEventListener('submit', function(e) {
    const form = e.target;
    const submitBtn = form.querySelector('button[type="submit"]');
    
    if (submitBtn && !submitBtn.dataset.noLoading) {
        submitBtn.disabled = true;
        const originalText = submitBtn.innerHTML;
        submitBtn.innerHTML = '<svg class="animate-spin -ml-1 mr-3 h-5 w-5 text-white inline" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path></svg> Processing...';
        
        // Reset after 10 seconds as fallback
        setTimeout(() => {
            submitBtn.disabled = false;
            submitBtn.innerHTML = originalText;
        }, 10000);
    }
});

// Show success toast from session
document.addEventListener('DOMContentLoaded', function() {
    // Check for success message
    const successMessage = document.querySelector('meta[name="success-message"]');
    if (successMessage) {
        Toast.fire({
            icon: 'success',
            title: successMessage.content
        });
    }

    // Check for error message
    const errorMessage = document.querySelector('meta[name="error-message"]');
    if (errorMessage) {
        Toast.fire({
            icon: 'error',
            title: errorMessage.content
        });
    }

    // Check for validation errors
    const validationErrors = document.querySelector('meta[name="validation-errors"]');
    if (validationErrors) {
        const errors = JSON.parse(validationErrors.content);
        let errorList = '<ul class="text-left">';
        errors.forEach(error => {
            errorList += `<li>${error}</li>`;
        });
        errorList += '</ul>';
        
        Swal.fire({
            icon: 'error',
            title: 'Validation Error',
            html: errorList,
            confirmButtonColor: '#3b82f6'
        });
    }
});
