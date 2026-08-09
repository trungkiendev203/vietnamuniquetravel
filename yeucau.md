Bạn là Senior PHP Architect, UI/UX Designer và Web Performance Engineer. Hãy triển khai hoàn chỉnh website du lịch cho thương hiệu Vietnam Unique Travel, không chỉ viết kế hoạch hoặc giao diện demo.

## 1. Tài liệu đầu vào

Trước khi lập trình, bắt buộc đọc kỹ toàn bộ:

1. `Thông tin tạo Website - VNU.docx`
2. `PU LUONG TOUR – PLT.docx`
3. Logo và hình ảnh thương hiệu được cung cấp.
4. Website tham khảo về phong cách UI: https://sovaba.travel/

Hai tài liệu Word là nguồn dữ liệu chính thức. Phải nhập đầy đủ thông tin doanh nghiệp, nội dung giới thiệu, tour, lịch trình, giá, chính sách, FAQ và thông tin đặt tour.

Không được tự ý thay đổi giá, thời gian, lịch trình hoặc thông tin liên hệ. Nếu dữ liệu nào chưa rõ, hãy tạo trường quản trị để cập nhật và ghi chú rõ, không tự bịa thông tin.

## 2. Mục tiêu dự án

Xây dựng website du lịch:

- Giao diện hiện đại, cao cấp vừa phải, thiên nhiên và giàu cảm xúc.
- Lấy cảm hứng từ cách trình bày của Sovaba Travel nhưng phải tạo thiết kế riêng cho Vietnam Unique Travel.
- Không sao chép mã nguồn, nội dung, hình ảnh hoặc nhận diện của Sovaba.
- Tập trung vào khách du lịch quốc tế.
- Ngôn ngữ mặc định là tiếng Anh, có chuyển đổi English/Vietnamese.
- Có khả năng giới thiệu, tìm kiếm và gửi yêu cầu đặt tour.
- Có trang quản trị để nhân viên tự cập nhật nội dung.
- Chạy nhanh, mượt và ổn định trên shared hosting cấu hình thấp.
- Tương thích cPanel, DirectAdmin, Apache hoặc LiteSpeed.
- Có thể cài đặt qua File Manager và phpMyAdmin.
- Không yêu cầu quyền root hoặc cấu hình riêng máy chủ.
- Không phụ thuộc dịch vụ trả phí nếu chưa được yêu cầu.

## 3. Công nghệ bắt buộc

Ưu tiên kiến trúc nhẹ:

- PHP 8.1 trở lên, ưu tiên PHP 8.2 nếu hosting hỗ trợ.
- PHP theo mô hình MVC tối giản, rõ ràng và dễ bảo trì.
- Composer PSR-4 Autoload.
- PDO và prepared statements.
- MySQL
- HTML5 semantic.
- CSS thuần có design system và CSS variables.
- JavaScript thuần, không sử dụng jQuery.
- PHPMailer hoặc giải pháp SMTP nhẹ để gửi email.
- Apache hoặc LiteSpeed với `.htaccess`.
- Không dùng React, Vue hoặc framework frontend nặng.
- Không yêu cầu Node.js trên hosting.
- Không dùng Bootstrap nguyên bộ.
- Không dùng Docker.
- Không yêu cầu Redis.
- Không yêu cầu Supervisor, queue worker hoặc tiến trình chạy nền.
- Không bắt buộc SSH hoặc Composer trên hosting.
- Không sử dụng tính năng chỉ hoạt động khi có quyền root.

Nếu hosting không hỗ trợ chạy Composer, phải chuẩn bị sẵn thư mục `vendor` production để người dùng chỉ cần upload source lên hosting.

Nếu dự án hiện tại đã có cấu trúc, phải kiểm tra trước và giữ tương thích. Không rewrite toàn bộ khi chưa cần thiết.

## 4. Cấu trúc triển khai trên hosting

Ưu tiên cấu trúc bảo mật:

- Các file ứng dụng, cấu hình, log và database migration đặt ngoài `public_html` nếu hosting cho phép.
- Chỉ file public, CSS, JavaScript, ảnh và `index.php` nằm trong `public_html`.
- Nếu bắt buộc đặt toàn bộ source trong `public_html`, phải dùng `.htaccess` chặn truy cập trực tiếp vào:
  - `.env`
  - config
  - storage
  - logs
  - migrations
  - vendor
  - backup
  - file SQL
  - file Word nguồn

- Tắt directory listing.
- Không để lộ thông tin database hoặc SMTP.
- Có cấu hình `base_url` để website hoạt động đúng cả khi đặt ở domain chính hoặc thư mục con.

Website phải hoạt động mà không cần chạy lệnh terminal sau khi upload. Nếu có lệnh tối ưu tùy chọn, vẫn phải cung cấp phương án cài đặt thủ công qua cPanel và phpMyAdmin.

## 5. Định hướng giao diện

Thiết kế mang tinh thần:

- Adventure.
- Nature.
- Authentic Local Culture.
- Responsible Tourism.
- Premium but Accessible.
- Modern và Minimal.
- Truyền cảm hứng khám phá Việt Nam.

### Màu sắc đề xuất

- Xanh rừng rất đậm: `#022F13`
- Xanh thương hiệu: `#005825`
- Xanh lá phụ: `#0B8F4D`
- Vàng ấm: `#F2C94C`
- Cam nhạt: `#F3A75B`
- Trắng ngà: `#F8F6EF`
- Màu chữ tối: `#14211A`

Không sử dụng màu đỏ làm màu nhận diện chính.

Font chữ:

- Heading: Manrope.
- Body: Inter.
- Ưu tiên self-host font dạng WOFF2 variable.
- Chỉ tải những font weight thực sự sử dụng.
- Sử dụng `font-display: swap`.
- Không phụ thuộc Google Fonts nếu có thể self-host.

Logo cần làm nổi bật chữ “UNIQUE”. Nếu chưa có logo chất lượng cao, chỉ tạo vị trí chờ, không phóng lớn logo mờ lấy từ tài liệu Word.

## 6. Thiết kế trang chủ

### Header

- Header trong suốt đặt trên hero.
- Logo bên trái.
- Menu bên phải: Home, Tours, Destinations, Experiences, About Us, Travel Guide, Contact.
- Nút nổi bật “Book a Tour”.
- Khi cuộn trang, header chuyển sang nền sáng hoặc xanh đậm.
- Mobile sử dụng menu drawer.
- Menu có thể đóng bằng nút, phím Escape và bấm ra ngoài.
- Hỗ trợ bàn phím và trình đọc màn hình.

### Hero

- Chiếm gần toàn bộ màn hình đầu tiên.
- Sử dụng ảnh Pù Luông chất lượng cao.
- Có gradient chuyển liền mạch từ ảnh thiên nhiên xuống nền xanh rừng `#022F13`.
- Không để lộ đường phân cách giữa hero và section tiếp theo.
- Heading tiếng Anh truyền cảm hứng, làm nổi bật “UNIQUE”.
- Có mô tả ngắn.
- Hai CTA:
  - Explore Our Tours
  - Plan Your Trip

- Có ô tìm kiếm “Where do you want to go?” nếu không ảnh hưởng tốc độ.
- Không autoplay video nặng.
- Ưu tiên ảnh hero WebP hoặc AVIF.

### Signature Tours

Thiết kế theo tinh thần section Tour hot của Sovaba:

- Nền xanh rừng đậm.
- Các tour đánh số lớn `01`, `02`, `03`.
- Số thứ tự màu trắng mờ.
- Đường kẻ và chữ “Signature Tour” màu vàng.
- Bố cục chữ và ảnh hai cột.
- Các tour tiếp theo đảo vị trí ảnh–chữ xen kẽ.
- Ảnh bo góc lớn và xoay nhẹ khoảng 2–3 độ.
- Chuyển động nhẹ khi cuộn nhưng không sử dụng thư viện animation nặng.
- Hiển thị thời lượng, độ khó, hình thức tour, giá từ và nút xem chi tiết.

Ưu tiên sử dụng các tour Pù Luông nổi bật từ file `PU LUONG TOUR – PLT.docx`.

### Các section còn lại

Sắp xếp trang chủ gọn:

1. Hero.
2. Signature Tours.
3. Experiences: Trekking, Cycling, Local Culture, Waterfall, Community Tourism.
4. Why Vietnam Unique Travel.
5. Featured Destinations.
6. Responsible Tourism.
7. Testimonials.
8. Travel Guide/Blog.
9. CTA đặt tour.
10. Footer.

Sử dụng:

- Section bo cong lớn.
- Card ảnh điểm đến.
- Collage ảnh thiên nhiên.
- Khoảng trắng hợp lý.
- Hiệu ứng hover tinh tế.
- Không lạm dụng carousel hoặc animation.
- Không để trang chủ quá dài và lặp lại nội dung.

## 7. Các trang cần triển khai

- Trang chủ.
- Danh sách tour.
- Chi tiết tour.
- Danh sách điểm đến.
- Chi tiết điểm đến.
- Experiences.
- About Us.
- Responsible Tourism.
- Blog/Travel Guide.
- Chi tiết bài viết.
- FAQ.
- Contact.
- Booking Request.
- Privacy Policy.
- Terms and Conditions.
- Booking, cancellation and date-change policy.
- Trang tìm kiếm.
- Trang 404.
- Trang xác nhận gửi yêu cầu đặt tour thành công.

Mỗi trang có tiếng Anh và tiếng Việt, sử dụng URL như `/en/...` và `/vi/...`, có canonical và hreflang phù hợp.

## 8. Trang chi tiết tour

Sử dụng bố cục tối ưu chuyển đổi.

### Cột nội dung

- Gallery ảnh.
- Tên tour.
- Địa điểm.
- Thời lượng.
- Độ khó.
- Phương tiện.
- Quy mô nhóm.
- Ngôn ngữ hướng dẫn.
- Điểm nổi bật.
- Lịch trình theo timeline.
- Giá theo số lượng khách.
- Bao gồm.
- Không bao gồm.
- Cần chuẩn bị gì.
- Chính sách trẻ em.
- Chính sách đổi/hủy.
- FAQ riêng.
- Tour liên quan.

### Booking card bên phải

- Giá từ.
- Chọn ngày dự kiến.
- Số người lớn.
- Số trẻ em.
- Nút “Book This Tour”.
- Nút WhatsApp.
- Hotline.
- Thông báo đội ngũ tư vấn sẽ kiểm tra và xác nhận.

Booking card chỉ sử dụng `position: sticky`, không dùng JavaScript nặng.

Trên mobile, chuyển thành CTA phía dưới nhưng không che nội dung.

Giai đoạn này chỉ gửi yêu cầu đặt tour, chưa tích hợp thanh toán online.

## 9. Biểu mẫu đặt tour

### Thông tin chuyến đi

- Tour khách quan tâm, bắt buộc.
- Ngày dự kiến tham gia, bắt buộc.
- Số lượng người lớn, bắt buộc.
- Số lượng trẻ em.
- Khách sạn hoặc địa điểm đón, bắt buộc.
- Yêu cầu ăn uống.
- Tình trạng sức khỏe cần lưu ý.
- Yêu cầu riêng.

### Thông tin khách hàng

- Họ và tên, bắt buộc.
- Quốc tịch.
- Email, bắt buộc.
- Số điện thoại/WhatsApp, bắt buộc.

### Xác nhận

- Checkbox đồng ý với chính sách bảo mật, bắt buộc.

### Quy trình xử lý

1. Validate phía trình duyệt và server.
2. Lưu đơn vào database trước.
3. Tạo mã booking request riêng.
4. Gửi thông báo đến `sales.vietnamuniquetravel@gmail.com`.
5. Gửi email xác nhận tự động cho khách.
6. Nội dung email sử dụng mẫu trong tài liệu Word.
7. Ngôn ngữ email theo ngôn ngữ khách đang sử dụng.
8. Nếu email lỗi, đơn vẫn được lưu.
9. Admin hiển thị trạng thái gửi email.
10. Không gửi dữ liệu tự động qua WhatsApp.
11. Áp dụng Post/Redirect/Get để không gửi lặp khi refresh.

SMTP cấu hình qua `.env`. Không hard-code tài khoản hoặc mật khẩu email.

## 10. Trang quản trị

Tạo admin panel nhẹ:

- Đăng nhập và đăng xuất.
- Dashboard thống kê.
- Quản lý tour.
- Quản lý lịch trình.
- Quản lý bảng giá.
- Quản lý điểm đến.
- Quản lý categories/experiences.
- Quản lý bài viết.
- Quản lý testimonials.
- Quản lý FAQ.
- Quản lý media.
- Quản lý booking.
- Trạng thái: New, Contacted, Confirmed, Completed, Cancelled.
- Ghi chú nội bộ.
- Quản lý thông tin liên hệ và mạng xã hội.
- Quản lý nội dung tiếng Anh và tiếng Việt.
- Quản lý SEO title, description, slug và ảnh chia sẻ.
- Đánh dấu tour nổi bật.
- Sắp xếp tour.
- Bật/tắt tour mà không xóa dữ liệu.

Không lưu mật khẩu plaintext. Tạo tài khoản admin bằng trang cài đặt bảo mật hoặc script tạo password hash. Trang cài đặt phải tự khóa hoặc được xóa sau khi hoàn tất.

## 11. Database

Tạo migration hoặc file SQL cho:

- admins
- tours
- tour_translations
- tour_images
- tour_itinerary_steps
- tour_prices
- destinations
- destination_translations
- categories
- tour_categories
- bookings
- posts
- post_translations
- testimonials
- faqs
- media
- settings

Yêu cầu:

- Có khóa ngoại khi hosting hỗ trợ InnoDB.
- Có index cho slug, status, featured, destination, category và ngày tạo.
- Giá dùng decimal hoặc integer, không dùng float.
- Nội dung tiếng Anh và tiếng Việt tách rõ.
- Không lưu ảnh base64.
- HTML từ admin phải được lọc theo danh sách thẻ cho phép.
- Database tương thích MySQL phổ biến trên shared hosting.
- Không yêu cầu extension database đặc biệt.

## 12. Nhập dữ liệu tài liệu

- Nhập toàn bộ tour trong `PU LUONG TOUR – PLT.docx`.
- Giữ nguyên mã PLHDT và PLFDT.
- Giữ chính xác lịch trình, thời gian, giá, số khách và phụ thu.
- Chuyển bảng giá Word thành dữ liệu database.
- Tạo seed data hoặc file SQL nhập sẵn.
- Hiển thị VND và USD nếu tài liệu có cả hai.
- Không tự tính tỷ giá.
- Nội dung tiếng Anh là dữ liệu chính.
- Bản tiếng Việt phải tự nhiên và cho phép quản trị viên kiểm tra.
- Nếu dữ liệu mâu thuẫn, liệt kê trong `DATA_REVIEW.md`.

## 13. Tối ưu cho shared hosting cấu hình thấp

Website phải chạy tốt khi:

- PHP memory limit khoảng 128MB.
- Không có quyền root.
- Không có tiến trình chạy nền.
- Không có Redis.
- Không có Node.js.
- Có thể không có SSH.
- Chỉ có cPanel/DirectAdmin, File Manager và phpMyAdmin.

Yêu cầu tối ưu:

- Một file CSS chính và một file JavaScript chính nếu có thể.
- CSS và JavaScript production được minify.
- JavaScript dùng `defer`.
- Initial JavaScript cố gắng dưới 60KB gzip.
- Initial CSS cố gắng dưới 80KB gzip.
- Không dùng icon font; dùng SVG.
- Không tải ảnh hoặc source từ Sovaba.
- Không hotlink ảnh.
- Tạo nhiều kích thước ảnh khi upload.
- Ưu tiên WebP; AVIF chỉ dùng nếu hosting hỗ trợ xử lý ổn định.
- Có ảnh JPEG dự phòng.
- Sử dụng `srcset` và `sizes`.
- Hero được preload hợp lý và có `fetchpriority="high"`.
- Ảnh phía dưới sử dụng lazy loading.
- Mọi ảnh có width và height.
- Không lazy-load ảnh LCP.
- Animation dùng CSS và IntersectionObserver.
- Hỗ trợ `prefers-reduced-motion`.
- Có file cache HTML nhẹ trong thư mục writable.
- Xóa cache khi admin cập nhật.
- Không cache trang admin, booking hoặc form có CSRF.
- Hạn chế truy vấn database.
- Tránh N+1.
- Phân trang danh sách trong admin.
- Không xử lý hàng loạt ảnh lớn trong một request.
- Giới hạn kích thước ảnh upload.
- Có chức năng xóa ảnh không còn sử dụng.
- Không ghi log quá lớn.
- Có cơ chế xoay hoặc dọn log.
- Website không được vượt memory limit khi xử lý request thông thường.

### `.htaccess`

Cung cấp `.htaccess`:

- Rewrite URL về `index.php`.
- Bật cache header cho CSS, JS, font và ảnh.
- Bật gzip qua `mod_deflate` nếu hosting hỗ trợ.
- Tắt directory listing.
- Chặn truy cập file nhạy cảm.
- Chuyển HTTPS nếu SSL đã được bật.
- Không sử dụng directive có nguy cơ gây lỗi 500 trên hosting không hỗ trợ.
- Các directive tùy chọn phải có chú thích để có thể tắt.

### Mục tiêu kiểm thử

- Lighthouse Performance mobile từ 90 trở lên trong điều kiện production hợp lý.
- Accessibility từ 90 trở lên.
- Best Practices từ 95 trở lên.
- SEO từ 95 trở lên.
- Không có layout shift rõ ràng.
- Trang chủ và trang tour hiển thị nhanh trên mạng di động.

Nếu chưa đạt, phải tiếp tục tối ưu và ghi rõ nguyên nhân.

## 14. SEO

- Một H1 duy nhất mỗi trang.
- Title và meta description riêng.
- Canonical.
- Hreflang EN/VI.
- Open Graph.
- Twitter Card.
- XML sitemap.
- robots.txt.
- Breadcrumb.
- Schema Organization.
- Schema BreadcrumbList.
- Schema TouristTrip hoặc Product cho tour.
- Schema FAQPage.
- Alt text có ý nghĩa.
- Slug dễ đọc.
- Blog và tour có metadata quản trị được.

## 15. Bảo mật

- CSRF cho tất cả form thay đổi dữ liệu.
- PDO prepared statements.
- Escape output.
- Validate và sanitize dữ liệu.
- Rate limit booking và contact bằng database hoặc file cache.
- Honeypot chống spam.
- Kiểm tra MIME, dung lượng và đuôi file upload.
- Đổi tên file upload ngẫu nhiên.
- Không cho upload PHP, `.htaccess`, executable hoặc script.
- Session cookie HttpOnly và SameSite.
- Bật Secure khi dùng HTTPS.
- Regenerate session ID sau đăng nhập.
- Password dùng `password_hash()` và `password_verify()`.
- Không hiển thị lỗi PHP trên production.
- Secrets lưu trong `.env`.
- Chặn truy cập `.env` bằng `.htaccess`.
- Không ghi dữ liệu sức khỏe hoặc thông tin nhạy cảm vào log.
- Không để file SQL và backup trong thư mục public.
- Có hướng dẫn đổi tên đường dẫn admin nếu cần.
- Không phụ thuộc cấu hình bảo mật chỉ có trên VPS.

## 16. Accessibility và responsive

Kiểm tra:

- 360px.
- 390px.
- 768px.
- 1024px.
- 1440px.

Yêu cầu:

- Không tràn ngang.
- Nút đủ lớn trên mobile.
- Có keyboard focus.
- Menu và gallery điều khiển được bằng bàn phím.
- Contrast đạt WCAG AA.
- Form có label thật.
- Lỗi form hiển thị cạnh trường.
- Nút carousel có aria-label.
- Tất cả ảnh có alt text phù hợp.

## 17. Thông tin liên hệ

Sử dụng đúng:

- Thương hiệu: Vietnam Unique Travel.
- Doanh nghiệp: Công ty Cổ phần Du lịch Thành Hưng.
- Website: vietnamuniquetravel.com.
- Hotline: +84 362 191 568.
- Điện thoại văn phòng: +84 943 642 389.
- Bộ phận kinh doanh: +84 988 956 496.
- Email: [sales.vietnamuniquetravel@gmail.com](mailto:sales.vietnamuniquetravel@gmail.com).
- Văn phòng: 200 Ngõ 192 Lê Trọng Tấn, Phường Phương Liệt, Hà Nội.
- Kênh hỗ trợ: WhatsApp, LINE, Zalo và iMessage.

Mạng xã hội chưa có URL thì không hiển thị liên kết giả.

## 18. Kết quả bàn giao

- Toàn bộ source chạy được.
- File `deploy-hosting.zip` sẵn sàng upload.
- Cấu trúc source phù hợp `public_html`.
- File `.htaccess`.
- File SQL có thể import bằng phpMyAdmin.
- Migration và seed dữ liệu.
- Thư mục `vendor` production nếu hosting không có Composer.
- `.env.example`.
- Không có mật khẩu thật trong source.
- Hướng dẫn tạo database và database user trên cPanel.
- Hướng dẫn import SQL bằng phpMyAdmin.
- Hướng dẫn upload và giải nén source bằng File Manager.
- Hướng dẫn cấu hình domain và thư mục gốc.
- Hướng dẫn bật PHP version và extension cần thiết.
- Hướng dẫn SMTP.
- Hướng dẫn phân quyền thư mục upload, cache và log.
- Hướng dẫn SSL bằng AutoSSL hoặc Let’s Encrypt có sẵn trên hosting.
- Hướng dẫn backup bằng cPanel.
- Hướng dẫn cập nhật source mà không mất dữ liệu.
- Tài khoản admin được tạo an toàn.
- `DATA_REVIEW.md`.
- `PERFORMANCE.md`.
- `README.md`.
- Không đóng gói cache, log, ảnh tạm hoặc dependency development.

Danh sách PHP extension cần thiết phải tối giản, ưu tiên các extension phổ biến:

- PDO MySQL.
- mbstring.
- fileinfo.
- openssl.
- json.
- GD hoặc Imagick.
- intl nếu hosting hỗ trợ.

Website vẫn phải hoạt động nếu không có Imagick; sử dụng GD làm phương án dự phòng.

## 19. Quy trình thực hiện

1. Kiểm tra source hiện tại.
2. Đọc toàn bộ tài liệu Word.
3. Ánh xạ nội dung sang trang và database.
4. Đưa ra kế hoạch ngắn.
5. Tiếp tục triển khai, không dừng ở kế hoạch.
6. Xây database và seed.
7. Xây frontend.
8. Xây booking flow.
9. Xây admin panel.
10. Tối ưu cho shared hosting.
11. Kiểm thử chức năng.
12. Kiểm tra responsive.
13. Kiểm tra booking và SMTP.
14. Chạy Lighthouse hoặc công cụ tương đương.
15. Sửa lỗi.
16. Tạo `deploy-hosting.zip`.
17. Viết hướng dẫn cài đặt bằng cPanel và phpMyAdmin.
18. Báo cáo chính xác phần đã hoàn thành và chưa hoàn thành.

Không được chỉ tạo landing page tĩnh. Không được để nút giả, link giả, form không hoạt động hoặc hard-code dữ liệu tour rải rác trong giao diện.

Website phải vận hành thực tế, cập nhật được qua admin và cài đặt được trên shared hosting mà không cần quyền root, VPS hoặc kiến thức quản trị máy chủ chuyên sâu.
