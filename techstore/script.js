const newsData = [
    {
        id: 1,
        title: "Apple chính thức ra mắt iPhone 18 Pro: Chip A20 Pro 2nm, Camera khẩu độ thay đổi",
        category: "Sản phẩm mới",
        shortDesc: "Apple vừa chính thức ra mắt dòng iPhone 18 Pro với vi xử lý A20 Pro 2nm siêu mạnh, camera Fusion 48MP có khẩu độ thay đổi linh hoạt và pin phát video lên tới 45 giờ.",
        content: "<p>Tại sự kiện vừa qua, Apple đã thu hút toàn bộ sự chú ý của giới công nghệ khi ra mắt hai siêu phẩm <strong>iPhone 18 Pro</strong> và <strong>iPhone 18 Pro Max</strong>.</p><p>Điểm nâng cấp đáng chú ý nhất chính là con chip <strong>A20 Pro</strong> sản xuất trên tiến trình 2nm tiên tiến, mang lại hiệu năng đồ họa tăng 40% và tiết kiệm điện tối ưu. Hệ thống camera Fusion 48MP lần đầu tiên hỗ trợ điều chỉnh khẩu độ vật lý (f/1.48 đến f/4.0), giúp chụp ảnh thiếu sáng đỉnh cao và tạo hiệu ứng xóa phông tự nhiên hơn.</p><p>Bên cạnh đó, cụm Dynamic Island đã được thu nhỏ 35%, tích hợp sâu cùng hệ thống Siri AI thế hệ mới trên iOS 27.</p>",
        date: "2026-09-10",
        author: "Minh Tuấn",
        views: 4820,
        readTime: "4 phút",
        image: "https://picsum.photos/800/400?random=10",
        tags: ["iPhone18", "Apple", "A20Pro", "Smartphone"]
    },
    {
        id: 2,
        title: "Đánh giá chi tiết RTX 5090: Sức mạnh đồ họa vượt giới hạn",
        category: "Đánh giá",
        shortDesc: "Thế hệ card đồ họa mới nhất mang lại hiệu năng gấp đôi so với tiền nhiệm nhưng mức tiêu thụ điện năng ra sao?",
        content: "<p>Card đồ họa RTX 5090 đánh dấu bước tiến lớn trong công nghệ xử lý đồ họa máy tính với kiến trúc mới hoàn toàn...</p><p>Qua thử nghiệm thực tế với các tựa game 4K Ray-Tracing, card cho tốc độ khung hình trung bình trên 120 FPS mượt mà.</p>",
        date: "2026-03-10",
        author: "Minh Tuấn",
        views: 1540,
        readTime: "5 phút",
        image: "https://picsum.photos/800/400?random=1",
        tags: ["NVIDIA", "RTX5090", "VGA"]
    },
    {
        id: 3,
        title: "Top 5 Laptop Gaming giá rẻ đáng mua nhất cho sinh viên",
        category: "Hướng dẫn",
        shortDesc: "Tổng hợp những mẫu laptop cấu hình mạnh, tản nhiệt tốt có giá dưới 20 triệu đồng trong năm nay.",
        content: "<p>Sinh viên ngành công nghệ và đồ họa luôn tìm kiếm giải pháp cân bằng giữa giá cả và hiệu năng...</p>",
        date: "2026-03-08",
        author: "Hoàng Nam",
        views: 890,
        readTime: "4 phút",
        image: "https://picsum.photos/800/400?random=2",
        tags: ["Laptop", "Gaming", "TuVan"]
    },
    {
        id: 4,
        title: "Bão Sale Công Nghệ: Giảm giá đến 50% toàn bộ phụ kiện",
        category: "Khuyến mãi",
        shortDesc: "Chương trình khuyến mãi cực lớn áp dụng cho chuột, bàn phím cơ và tai nghe không dây duy nhất cuối tuần này.",
        content: "<p>Đừng bỏ lỡ cơ hội sở hữu phụ kiện công nghệ chính hãng với mức giá hời nhất năm...</p>",
        date: "2026-03-05",
        author: "TechStore Admin",
        views: 2300,
        readTime: "2 phút",
        image: "https://picsum.photos/800/400?random=3",
        tags: ["KhuyenMai", "PhuKien"]
    }
];

let currentPage = 1;
const itemsPerPage = 2;
let filteredNews = [...newsData];

const pathname = window.location.pathname;

if (pathname.includes('index.html') || pathname.endsWith('/') || !pathname.includes('.html')) {
    document.addEventListener('DOMContentLoaded', () => {
        renderNewsList();

        const searchInput = document.getElementById('search-input');
        const categorySelect = document.getElementById('category-select');
        const sortSelect = document.getElementById('sort-select');

        if (searchInput) searchInput.addEventListener('input', filterNews);
        if (categorySelect) categorySelect.addEventListener('change', filterNews);
        if (sortSelect) sortSelect.addEventListener('change', filterNews);
    });
}

if (pathname.includes('news_detail.html')) {
    document.addEventListener('DOMContentLoaded', () => {
        const urlParams = new URLSearchParams(window.location.search);
        const articleId = parseInt(urlParams.get('id')) || 1;
        renderNewsDetail(articleId);
    });
}

function filterNews() {
    const keyword = document.getElementById('search-input').value.toLowerCase().trim();
    const category = document.getElementById('category-select').value;
    const sort = document.getElementById('sort-select').value;

    filteredNews = newsData.filter(item => {
        const matchesSearch = item.title.toLowerCase().includes(keyword) || 
                              item.shortDesc.toLowerCase().includes(keyword) ||
                              item.tags.some(tag => tag.toLowerCase().includes(keyword));
        const matchesCat = category === 'all' || item.category === category;
        return matchesSearch && matchesCat;
    });

    if (sort === 'newest') filteredNews.sort((a,b) => new Date(b.date) - new Date(a.date));
    if (sort === 'oldest') filteredNews.sort((a,b) => new Date(a.date) - new Date(b.date));
    if (sort === 'views') filteredNews.sort((a,b) => b.views - a.views);

    currentPage = 1;
    renderNewsList();
}

function renderNewsList() {
    const listContainer = document.getElementById('news-list');
    if(!listContainer) return;
    listContainer.innerHTML = '';

    if (filteredNews.length === 0) {
        listContainer.innerHTML = `<p style="grid-column: 1/-1; padding: 20px 0;">Không tìm thấy bài viết nào phù hợp!</p>`;
        document.getElementById('pagination').innerHTML = '';
        return;
    }

    const start = (currentPage - 1) * itemsPerPage;
    const paginatedItems = filteredNews.slice(start, start + itemsPerPage);

    paginatedItems.forEach(item => {
        const card = document.createElement('article');
        card.style.cursor = 'pointer';
        card.onclick = () => window.location.href = `news_detail.html?id=${item.id}`;
        card.innerHTML = `
            <img src="${item.image}" alt="${item.title}" style="width:100%; height:200px; object-fit:cover; margin-bottom:15px;">
            <p class="eyebrow">${item.category}</p>
            <h2>${item.title}</h2>
            <p style="font-size: 13px; color: #008da8; margin: 5px 0;">${item.date} • ${item.readTime} đọc • ${item.views} lượt xem</p>
            <p>${item.shortDesc}</p>
        `;
        listContainer.appendChild(card);
    });

    renderPagination();
}

function renderPagination() {
    const totalPages = Math.ceil(filteredNews.length / itemsPerPage);
    const paginationBox = document.getElementById('pagination');
    if(!paginationBox) return;
    paginationBox.innerHTML = '';

    if (totalPages <= 1) return;

    for (let i = 1; i <= totalPages; i++) {
        const btn = document.createElement('button');
        btn.innerText = i;
        if (i === currentPage) btn.classList.add('active');
        btn.onclick = () => {
            currentPage = i;
            renderNewsList();
            window.scrollTo({ top: 100, behavior: 'smooth' });
        };
        paginationBox.appendChild(btn);
    }
}

function renderNewsDetail(id) {
    const article = newsData.find(item => item.id === id) || newsData[0];
    const detailContainer = document.getElementById('article-detail-content');
    if(!detailContainer) return;

    detailContainer.innerHTML = `
        <p class="eyebrow">${article.category}</p>
        <h1 style="margin-top: 10px;">${article.title}</h1>
        <p style="color: #008da8; font-weight: bold; margin-bottom: 20px;">
            Tác giả: ${article.author} | Ngày đăng: ${article.date} | ${article.views} lượt xem
        </p>
        <img src="${article.image}" alt="${article.title}" style="width: 100%; max-height: 400px; object-fit: cover; margin-bottom: 20px;">
        <div style="line-height: 1.8; font-size: 17px;">${article.content}</div>
    `;
}

function previewImage(event) {
    const previewContainer = document.getElementById('image-preview');
    if(!previewContainer) return;
    previewContainer.innerHTML = '';
    const file = event.target.files[0];
    if (file) {
        const reader = new FileReader();
        reader.onload = function(e) {
            previewContainer.innerHTML = `<img src="${e.target.result}" alt="Preview" style="width: 80px; height: 80px; object-fit: cover; border: 1px solid #c9d2dc;">`;
        }
        reader.readAsDataURL(file);
    }
}

function handleFormSubmit(event) {
    event.preventDefault();
    const name = document.getElementById('fullname').value;
    const alertBox = document.getElementById('alert-box');
    
    alertBox.innerText = `Cảm ơn ${name}! Yêu cầu liên hệ của bạn đã được gửi thành công.`;
    alertBox.style.display = 'block';
    
    document.getElementById('contact-form').reset();
    document.getElementById('image-preview').innerHTML = '';
    
    window.scrollTo({ top: 0, behavior: 'smooth' });
}