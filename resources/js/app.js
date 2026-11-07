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
            confirmButton: 'px-5 py-2.5 rounded-xl text-xs sm:text-sm font-bold shadow-xs cursor-pointer',
            cancelButton: 'px-5 py-2.5 rounded-xl text-xs sm:text-sm font-bold cursor-pointer'
        }
    }).then(result => result.isConfirmed);
};

/**
 * Universal Data-Confirm Listener:
 * Automatically intercepts form submits or button clicks with [data-confirm]
 * and shows SweetAlert2 confirmation modal before proceeding.
 */
document.addEventListener('DOMContentLoaded', () => {
    // Intercept form submits with data-confirm (either on form or clicked submit button)
    document.addEventListener('submit', (e) => {
        const form = e.target;
        if (!form) return;

        // Tandai flag logout di sessionStorage saat pengguna keluar
        if (form.action && form.action.indexOf('/logout') !== -1) {
            try { sessionStorage.setItem('siperka_logged_out', 'true'); } catch (_) { }
        }

        const submitter = e.submitter;
        const confirmSource = (submitter && submitter.dataset && submitter.dataset.confirm)
            ? submitter
            : (form.dataset && form.dataset.confirm ? form : null);

        if (confirmSource && !form.dataset.confirmed) {
            e.preventDefault();
            window.confirmAction({
                title: confirmSource.dataset.confirmTitle || 'Konfirmasi Tindakan',
                text: confirmSource.dataset.confirm,
                icon: confirmSource.dataset.confirmIcon || 'warning',
                confirmText: confirmSource.dataset.confirmButton || 'Ya, Lanjutkan',
                cancelText: confirmSource.dataset.cancelButton || 'Batal',
                confirmColor: confirmSource.dataset.confirmColor || '#176B4D'
            }).then((confirmed) => {
                if (confirmed) {
                    form.dataset.confirmed = 'true';
                    // Jika tombol submit punya name dan value, tambahkan hidden input agar tidak hilang saat form.submit()
                    if (submitter && submitter.name) {
                        const hidden = document.createElement('input');
                        hidden.type = 'hidden';
                        hidden.name = submitter.name;
                        hidden.value = submitter.value;
                        form.appendChild(hidden);
                    }
                    form.submit();
                }
            });
        }
    });

    // Intercept link clicks with data-confirm
    document.addEventListener('click', (e) => {
        const link = e.target.closest('a[data-confirm]');
        if (link && !link.dataset.confirmed) {
            e.preventDefault();
            window.confirmAction({
                title: link.dataset.confirmTitle || 'Konfirmasi Tindakan',
                text: link.dataset.confirm,
                icon: link.dataset.confirmIcon || 'warning',
                confirmText: link.dataset.confirmButton || 'Ya, Lanjutkan',
                cancelText: link.dataset.cancelButton || 'Batal',
                confirmColor: link.dataset.confirmColor || '#176B4D'
            }).then((confirmed) => {
                if (confirmed) {
                    link.dataset.confirmed = 'true';
                    window.location.href = link.href;
                }
            });
            return;
        }

        // Handle button[data-reset-form] to safely clear form with SweetAlert
        const resetBtn = e.target.closest('[data-reset-form]');
        if (resetBtn) {
            e.preventDefault();
            const form = resetBtn.closest('form');
            if (!form) return;

            window.confirmAction({
                title: resetBtn.dataset.confirmTitle || 'Kosongkan Formulir?',
                text: resetBtn.dataset.confirmText || 'Semua isian yang telah Anda ketik akan dibersihkan kembali ke kondisi awal.',
                icon: 'question',
                confirmText: 'Ya, Kosongkan Form',
                cancelText: 'Batal',
                confirmColor: '#E11D48'
            }).then((confirmed) => {
                if (confirmed) {
                    form.reset();
                    // Juga bersihkan value untuk input yang terisi value blade/old
                    form.querySelectorAll('input:not([type="hidden"]):not([type="checkbox"]):not([type="radio"]), textarea').forEach(input => {
                        input.value = '';
                    });
                    form.querySelectorAll('select').forEach(select => {
                        select.selectedIndex = 0;
                    });
                    const firstInput = form.querySelector('input:not([type="hidden"]):not([disabled])');
                    if (firstInput) firstInput.focus();
                    window.toast('info', 'Formulir berhasil dikosongkan.');
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
