// ==============================================================
// VARIABEL & FUNGSI GLOBAL (dari berbagai file)
// ==============================================================

// --- Dari statistik.php ---
let autoRefreshInterval;
let isAutoRefreshEnabled = true;

// --- Dari header.php (Logika Notifikasi) ---
function toggleNotificationPanel() {
    const panel = document.getElementById("notificationPanel");
    const isActive = panel.classList.contains("active");
    if (!isActive) {
        panel.classList.add("active");
        loadNotifications();
    } else {
        panel.classList.remove("active");
    }
}

async function loadNotifications() {
    const listEl = document.getElementById("notificationList");
    listEl.innerHTML =
        '<div class="notification-loading">Memuat notifikasi...</div>';
    try {
        // PENTING: Ubah URL ini ke rute Laravel nanti
        const response = await fetch("notifikasi_api.php?action=get");
        const data = await response.json();
        if (data.success && data.notifications.length > 0) {
            let html = "";
            data.notifications.forEach((notif) => {
                const unreadClass = notif.is_read == 0 ? "unread" : "";
                html += `
                    <div class="notification-item ${unreadClass}" onclick="markAsRead(${
                    notif.id
                })">
                        <div class="notification-content">${notif.message}</div>
                        <div class="notification-time">${formatDate(
                    notif.created_at
                )}</div>
                    </div>
                `;
            });
            listEl.innerHTML = html;
        } else {
            listEl.innerHTML =
                '<div class="notification-empty">Tidak ada notifikasi</div>';
        }
    } catch (error) {
        console.error("Error loading notifications:", error);
        listEl.innerHTML =
            '<div class="notification-empty">Gagal memuat notifikasi</div>';
    }
}

async function markAsRead(id) {
    try {
        // PENTING: Ubah URL ini ke rute Laravel nanti
        await fetch("notifikasi_api.php?action=mark_read&id=" + id);
        loadNotifications();
        updateBadge();
    } catch (error) {
        console.error("Error marking as read:", error);
    }
}

async function markAllAsRead() {
    try {
        // PENTING: Ubah URL ini ke rute Laravel nanti
        await fetch("notifikasi_api.php?action=mark_all_read");
        loadNotifications();
        updateBadge();
    } catch (error) {
        console.error("Error marking all as read:", error);
    }
}

async function updateBadge() {
    try {
        // PENTING: Ubah URL ini ke rute Laravel nanti
        const response = await fetch("notifikasi_api.php?action=count");
        const data = await response.json();
        const badge = document.querySelector(".notification-badge");
        if (data.count > 0) {
            if (badge) {
                badge.textContent = data.count;
            } else {
                const btn = document.querySelector(".btn-notification");
                const newBadge = document.createElement("span");
                newBadge.className = "notification-badge";
                newBadge.textContent = data.count;
                btn.appendChild(newBadge);
            }
        } else {
            if (badge) {
                badge.remove();
            }
        }
    } catch (error) {
        console.error("Error updating badge:", error);
    }
}

function formatDate(dateStr) {
    // Versi "Time Ago" dari header.php
    const date = new Date(dateStr);
    const now = new Date();
    const diff = now - date;
    const minutes = Math.floor(diff / 60000);
    const hours = Math.floor(diff / 3600000);
    const days = Math.floor(diff / 86400000);
    if (minutes < 1) return "Baru saja";
    if (minutes < 60) return minutes + " menit yang lalu";
    if (hours < 24) return hours + " jam yang lalu";
    if (days < 7) return days + " hari yang lalu";
    return date.toLocaleDateString("id-ID", {
        day: "numeric",
        month: "short",
        year: "numeric",
    });
}

// Auto refresh notifications
setInterval(function () {
    updateBadge();
}, 30000);

// --- Dari komentar.php ---
function confirmDelete(id) {
    if (confirm("Apakah Anda yakin ingin menghapus komentar ini?")) {
        // PENTING: Ini harus diubah menjadi rute Laravel
        // const filter = '<?= $viewData['filter'] ?>';
        // window.location.href = `komentar_delete.php?id=${id}&filter=${filter}`;
        // Untuk sementara, kita buat form dan submit
        const form = document.createElement("form");
        form.method = "POST";
        form.action = `/admin/komentar/${id}`; // Contoh rute Laravel
        const hiddenMethod = document.createElement("input");
        hiddenMethod.type = "hidden";
        hiddenMethod.name = "_method";
        hiddenMethod.value = "DELETE";
        form.appendChild(hiddenMethod);
        const csrfToken = document
            .querySelector('meta[name="csrf-token"]')
            .getAttribute("content"); // Perlu tag meta csrf
        const hiddenToken = document.createElement("input");
        hiddenToken.type = "hidden";
        hiddenToken.name = "_token";
        hiddenToken.value = csrfToken;
        form.appendChild(hiddenToken);
        document.body.appendChild(form);
        form.submit();
    }
}

async function openBalasanModal(idKomentar) {
    document.getElementById("inputIdKomentar").value = idKomentar;
    document.getElementById("textBalasan").value = "";
    try {
        // PENTING: Ubah URL ini ke rute Laravel nanti
        const response = await fetch(`komentar_detail.php?id=${idKomentar}`);
        const data = await response.json();
        if (data.success) {
            const komentarHtml = `
                <div class="modal-komentar-header">
                    <span class="modal-komentar-name">${
                data.komentar.nama_pasien
            }</span>
                    <div class="modal-komentar-rating">
                        ${generateStars(data.komentar.rating)}
                    </div>
                </div>
                <div class="modal-komentar-text">${data.komentar.komentar}</div>
                <div class="modal-komentar-date">${formatDateLokal(
                data.komentar.tanggal_komentar
            )}</div>
            `;
            document.getElementById("komentarOriginal").innerHTML =
                komentarHtml;
            const balasanListEl = document.getElementById("balasanList");
            if (data.balasan && data.balasan.length > 0) {
                let balasanHtml = "";
                data.balasan.forEach((b) => {
                    balasanHtml += `
                        <div class="balasan-item">
                            <div class="balasan-header">
                                <span class="balasan-admin">👤 ${
                        b.nama_admin
                    }</span>
                                    <span class="balasan-date">${formatDateLokal(
                        b.tanggal_balasan
                    )}</span>
                                </div>
                                <div class="balasan-text">${b.balasan}</div>
                            </div>
                    `;
                });
                balasanListEl.innerHTML = balasanHtml;
            } else {
                balasanListEl.innerHTML =
                    '<div class="balasan-empty">Belum ada balasan</div>';
            }
            document.getElementById("modalBalasan").classList.add("active");
        }
    } catch (error) {
        console.error("Error:", error);
        alert("Gagal memuat data komentar");
    }
}

function closeBalasanModal() {
    document.getElementById("modalBalasan").classList.remove("active");
}

function generateStars(rating) {
    let html = "";
    for (let i = 1; i <= 5; i++) {
        html += `<span class="star ${i <= rating ? "" : "empty"}">★</span>`;
    }
    return html;
}

function formatDateLokal(dateStr) {
    // Versi dari komentar.php
    const date = new Date(dateStr);
    const options = {
        year: "numeric",
        month: "long",
        day: "numeric",
        hour: "2-digit",
        minute: "2-digit",
    };
    return date.toLocaleDateString("id-ID", options);
}

// --- Dari pengaturan.php ---
function openEditModal() {
    document.getElementById("modalEdit").classList.add("active");
}

function closeEditModal() {
    document.getElementById("modalEdit").classList.remove("active");
}

function confirmDeleteProfile() {
    // Ganti nama agar tidak konflik
    if (
        confirm(
            "⚠️ PERINGATAN!\n\nApakah Anda yakin ingin menghapus akun ini?\nSemua data akan dihapus permanen dan tidak dapat dikembalikan."
        )
    ) {
        // PENTING: Ubah ini ke rute Laravel
        // window.location.href = 'pengaturan.php?action=delete_account';
        // Kirim sebagai form DELETE
        const form = document.createElement("form");
        form.method = "POST";
        form.action = "/admin/pengaturan"; // Contoh rute Laravel
        const hiddenMethod = document.createElement("input");
        hiddenMethod.type = "hidden";
        hiddenMethod.name = "_method";
        hiddenMethod.value = "DELETE";
        form.appendChild(hiddenMethod);
        const csrfToken = document
            .querySelector('meta[name="csrf-token"]')
            .getAttribute("content"); // Perlu tag meta csrf
        const hiddenToken = document.createElement("input");
        hiddenToken.type = "hidden";
        hiddenToken.name = "_token";
        hiddenToken.value = csrfToken;
        form.appendChild(hiddenToken);
        document.body.appendChild(form);
        form.submit();
    }
}

// --- Dari statistik.php ---
async function fetchData() {
    const startDate = document.getElementById("startDate").value;
    const endDate = document.getElementById("endDate").value;
    try {
        // PENTING: Ubah URL ini ke rute Laravel nanti
        const response = await fetch(
            `statistik_api.php?start_date=${startDate}&end_date=${endDate}`
        );
        const result = await response.json();
        if (result.success) {
            updateChart(result.data);
            updateLastUpdate(result.data.timestamp);
        }
    } catch (error) {
        console.error("Error fetching data:", error);
    }
}

function updateChart(data) {
    // ... (salin sisa fungsi updateChart dari statistik.php) ...
}
function updateLastUpdate(timestamp) {
    // ... (salin sisa fungsi updateLastUpdate dari statistik.php) ...
}
function applyFilter() {
    // ... (salin sisa fungsi applyFilter dari statistik.php) ...
}
function manualRefresh() {
    // ... (salin sisa fungsi manualRefresh dari statistik.php) ...
}
function showLoading() {
    // ... (salin sisa fungsi showLoading dari statistik.php) ...
}
function hideLoading() {
    // ... (salin sisa fungsi hideLoading dari statistik.php) ...
}
function startAutoRefresh() {
    isAutoRefreshEnabled = true;
    autoRefreshInterval = setInterval(() => {
        fetchData();
    }, 30000);
    updateRefreshButton();
}
function stopAutoRefresh() {
    // ... (salin sisa fungsi stopAutoRefresh dari statistik.php) ...
}
function toggleAutoRefresh() {
    // ... (salin sisa fungsi toggleAutoRefresh dari statistik.php) ...
}
function updateRefreshButton() {
    // ... (salin sisa fungsi updateRefreshButton dari statistik.php) ...
}

// --- Dari transaksi.php ---
function setDefaultDateTime() {
    const now = new Date();
    const year = now.getFullYear();
    const month = String(now.getMonth() + 1).padStart(2, "0");
    const day = String(now.getDate()).padStart(2, "0");
    const hours = String(now.getHours()).padStart(2, "0");
    const minutes = String(now.getMinutes()).padStart(2, "0");
    const datetime = `${year}-${month}-${day}T${hours}:${minutes}`;
    document.getElementById("tanggal").value = datetime;
}
function openModalTambah() {
    setDefaultDateTime();
    document.getElementById("modalTambah").classList.add("show");
    document.body.style.overflow = "hidden";
}
function closeModalTambah() {
    document.getElementById("modalTambah").classList.remove("show");
    document.body.style.overflow = "auto";
}
function openModalEdit() {
    document.getElementById("modalEdit").classList.add("show");
    document.body.style.overflow = "hidden";
}
function closeModalEdit() {
    document.getElementById("modalEdit").classList.remove("show");
    document.body.style.overflow = "auto";
}
function editTransaksi(id, keterangan, nominal, tanggal, bank) {
    document.getElementById("edit_id").value = id;
    document.getElementById("edit_keterangan").value = keterangan;
    document.getElementById("edit_nominal").value = nominal;
    document.getElementById("edit_bank").value = bank;
    const date = new Date(tanggal);
    const year = date.getFullYear();
    const month = String(date.getMonth() + 1).padStart(2, "0");
    const day = String(date.getDate()).padStart(2, "0");
    const hours = String(date.getHours()).padStart(2, "0");
    const minutes = String(date.getMinutes()).padStart(2, "0");
    document.getElementById(
        "edit_tanggal"
    ).value = `${year}-${month}-${day}T${hours}:${minutes}`;
    openModalEdit();
}
function hapusTransaksi(id) {
    if (
        confirm(
            "⚠️ Apakah Anda yakin ingin menghapus transaksi ini?\n\nData yang dihapus tidak dapat dikembalikan."
        )
    ) {
        // PENTING: Ubah ini ke rute Laravel
        // window.location.href = 'transaksi.php?action=hapus&id=' + id;
        // Kirim sebagai form DELETE
        const form = document.createElement("form");
        form.method = "POST";
        form.action = `/admin/transaksi/${id}`; // Contoh rute Laravel
        const hiddenMethod = document.createElement("input");
        hiddenMethod.type = "hidden";
        hiddenMethod.name = "_method";
        hiddenMethod.value = "DELETE";
        form.appendChild(hiddenMethod);
        const csrfToken = document
            .querySelector('meta[name="csrf-token"]')
            .getAttribute("content"); // Perlu tag meta csrf
        const hiddenToken = document.createElement("input");
        hiddenToken.type = "hidden";
        hiddenToken.name = "_token";
        hiddenToken.value = csrfToken;
        form.appendChild(hiddenToken);
        document.body.appendChild(form);
        form.submit();
    }
}
function validateForm(form) {
    const nominal = form.querySelector('[name="nominal"]').value;
    if (parseFloat(nominal) <= 0) {
        alert("⚠️ Nominal harus lebih besar dari 0");
        return false;
    }
    return true;
}

// ==============================================================
// EVENT LISTENERS (dijalankan saat halaman siap)
// ==============================================================
document.addEventListener("DOMContentLoaded", function () {
    // --- Dari main.js (Modal Logout) ---
    const logoutTriggers = document.querySelectorAll(".logout-trigger");
    const logoutModal = document.getElementById("logout-modal");
    const noButton = document.getElementById("logout-tidak");

    if (logoutModal) {
        logoutTriggers.forEach(function (trigger) {
            trigger.addEventListener("click", function (event) {
                event.preventDefault();
                logoutModal.style.display = "flex";
            });
        });
        if (noButton) {
            noButton.addEventListener("click", function () {
                logoutModal.style.display = "none";
            });
        }
        logoutModal.addEventListener("click", function (event) {
            if (event.target === logoutModal) {
                logoutModal.style.display = "none";
                D;
            }
        });
    } // --- Dari komentar.php (Search & Modal Click) ---

    const searchInput = document.getElementById("searchInput");
    if (searchInput) {
        searchInput.addEventListener("input", function (e) {
            const searchTerm = e.target.value.toLowerCase();
            const cards = document.querySelectorAll(".komentar-card");
            cards.forEach((card) => {
                const searchData = card.getAttribute("data-search");
                if (searchData.includes(searchTerm)) {
                    card.style.display = "block";
                } else {
                    card.style.display = "none";
                }
            });
        });
    }
    const modalBalasan = document.getElementById("modalBalasan");
    if (modalBalasan) {
        modalBalasan.addEventListener("click", function (e) {
            if (e.target === this) {
                closeBalasanModal();
            }
        });
    } // --- Dari pengaturan.php (Modal Click) ---

    const modalEdit = document.getElementById("modalEdit");
    if (modalEdit) {
        modalEdit.addEventListener("click", function (e) {
            if (e.target === this) {
                closeEditModal();
            }
        });
    } // --- Dari statistik.php (Initialize) ---

    const barChart = document.getElementById("barChart");
    if (barChart) {
        startAutoRefresh();
        console.log("✅ Auto-refresh aktif - Update setiap 30 detik");
    } // --- Dari transaksi.php (Alerts & Modal Click) ---

    const alerts = document.querySelectorAll(".alert");
    alerts.forEach((alert) => {
        setTimeout(() => {
            alert.style.opacity = "0";
            alert.style.transform = "translateY(-10px)";
            setTimeout(() => alert.remove(), 300);
        }, 5000);
    });

    const modalTambahTrans = document.getElementById("modalTambah");
    const modalEditTrans = document.getElementById("modalEdit");
    window.onclick = function (event) {
        if (event.target === modalTambahTrans) {
            closeModalTambah();
        }
        if (event.target === modalEditTrans) {
            closeModalEdit();
        }
    };
});

// --- Dari statistik.php (Cleanup) ---
window.addEventListener("beforeunload", function () {
    if (document.getElementById("barChart")) {
        stopAutoRefresh();
    }
});
