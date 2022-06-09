const months = [
    'Januari',
    'Februari',
    'Maret',
    'April',
    'Mei',
    'Juni',
    'Juli',
    'Agustus',
    'September',
    'Oktober',
    'November',
    'Desember'
]

function formatTanggal(d) {
    const year = d.getFullYear();
    const date = d.getDate();
    const monthName = months[d.getMonth()];

    return `${date} ${monthName} ${year}`;

}
