import Alpine from 'alpinejs';
import Chart from 'chart.js/auto';
import Swal from 'sweetalert2';

window.Alpine = Alpine;
window.Chart = Chart;
window.Swal = Swal;

/**
 * Toast Notification Helper (SISPERKA Style)
 */
window.toast = (icon, title, timer = 3500) => {
    const isDark = document.documentElement.classList.contains('dark');
    return Swal.fire({
        toast: true,
        position: 'top-end',
        icon: icon,
        title: title,
        showConfirmButton: false,
        timer: timer,
        timerProgressBar: true,
        background: isDark ? '#16231D' : '#FFFFFF',
        color: isDark ? '#F1F5F9' : '#0F172A',
        didOpen: (toast) => {
            toast.addEventListener('mouseenter', Swal.stopTimer);
            toast.addEventListener('mouseleave', Swal.resumeTimer);
        },
        customClass: {
            popup: 'rounded-2xl border border-slate-200/90 dark:border-slate-800 shadow-xl text-xs sm:text-sm font-semibold'
        }
    });
};

/**
 * Modern Confirmation Dialog Helper
 * Resolves to true if user clicks confirm, false otherwise.
 */
window.confirmAction = (options = {}) => {
    const isDark = document.documentElement.classList.contains('dark');
    return Swal.fire({
        title: options.title || 'Apakah Anda yakin?',
        text: options.text || '',
        icon: options.icon || 'warning',
        showCancelButton: true,
        confirmButtonColor: options.confirmColor || '#176B4D',
        cancelButtonColor: options.cancelColor || '#64748B',
        confirmButtonText: options.confirmText || 'Ya, Lanjutkan',
        cancelButtonText: options.cancelText || 'Batal',
        reverseButtons: true,
        background: isDark ? '#16231D' : '#FFFFFF',
        color: isDark ? '#F1F5F9' : '#0F172A',
        customClass: {
            popup: 'rounded-2xl border border-slate-200/90 dark:border-slate-800 shadow-2xl p-6',
            confirmButton: 'px-5 py-2.5 rounded-xl text-xs sm:text-sm font-bold shadow-xs',
            cancelButton: 'px-5 py-2.5 rounded-xl text-xs sm:text-sm font-bold'
        }
    }).then(result => result.isConfirmed);
};

/**
 * Universal Data-Confirm Listener:
 * Automatically intercepts form submits with [data-confirm]
 * and shows SweetAlert2 confirmation modal before proceeding.
 */
document.addEventListener('DOMContentLoaded', () => {
    document.addEventListener('submit', (e) => {
        const form = e.target;
        if (form && form.dataset && form.dataset.confirm && !form.dataset.confirmed) {
            e.preventDefault();
            window.confirmAction({
                title: form.dataset.confirmTitle || 'Konfirmasi Tindakan',
                text: form.dataset.confirm,
                icon: form.dataset.confirmIcon || 'warning',
                confirmText: form.dataset.confirmButton || 'Ya, Lanjutkan',
                cancelText: form.dataset.cancelButton || 'Batal',
                confirmColor: form.dataset.confirmColor || '#176B4D'
            }).then((confirmed) => {
                if (confirmed) {
                    form.dataset.confirmed = 'true';
                    form.submit();
                }
            });
        }
    });

    // Check for Flash Messages from Laravel Blade
    const flashContainer = document.getElementById('sisperka-flash-messages');
    if (flashContainer) {
        if (flashContainer.dataset.success) {
            window.toast('success', flashContainer.dataset.success);
        }
        if (flashContainer.dataset.error) {
            window.toast('error', flashContainer.dataset.error);
        }
        if (flashContainer.dataset.status) {
            window.toast('info', flashContainer.dataset.status);
        }
        if (flashContainer.dataset.warning) {
            window.toast('warning', flashContainer.dataset.warning);
        }
    }
});

Alpine.start();
