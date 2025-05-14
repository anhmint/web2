// Hàm để thêm sản phẩm vào giỏ hàngs
function addToCart(productName, price) {
    // Lấy các sản phẩm đã có trong giỏ từ localStorage hoặc khởi tạo mảng rỗng
    let cartItems = JSON.parse(localStorage.getItem("cartItems")) || [];
    cartItems.push({ name: productName, price: price });
    localStorage.setItem("cartItems", JSON.stringify(cartItems));
    alert(`${productName} đã được thêm vào giỏ hàng!`);
}

// Hàm để hiển thị các sản phẩm trong giỏ trên trang giohang.html
function displayCartItems() {
    const cartItems = JSON.parse(localStorage.getItem("cartItems")) || [];
    const cartContainer = document.getElementById("cart-items");
    const priceTotal = document.getElementById("price-total");

    let total = 0;
    cartContainer.innerHTML = ""; // Xóa các sản phẩm trước đó

    cartItems.forEach(item => {
        // Tạo một div sản phẩm cho từng sản phẩm trong giỏ
        const itemDiv = document.createElement("div");
        itemDiv.classList.add("cart-item");
        itemDiv.innerHTML = `
            <p>${item.name} - $${item.price}</p>
        `;
        cartContainer.appendChild(itemDiv);

        // Tính tổng tiền
        total += parseFloat(item.price);
    });

    // Cập nhật hiển thị tổng tiền
    priceTotal.textContent = total.toFixed(2);
}

// Chạy hàm displayCartItems khi trang được tải
window.onload = displayCartItems;
