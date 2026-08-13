<?php
$isVi = ($lang ?? 'en') === 'vi';
?>
<!-- FLOATING AI ROBOT CHATBOT COMPONENT -->
<div id="aiChatbotWrapper" class="ai-chatbot-wrapper">
  
  <!-- Floating Robot Trigger Button -->
  <button id="chatbotTriggerBtn" class="chatbot-trigger-btn" aria-label="<?= $isVi ? 'Trò chuyện với Trợ lý AI' : 'Chat with AI Travel Assistant' ?>" title="<?= $isVi ? 'Trợ lý du lịch AI - Vietnam Unique Travel' : 'AI Travel Assistant - Vietnam Unique Travel' ?>">
    <span class="chatbot-pulse-ring"></span>
    <span class="chatbot-online-dot"></span>
    
    <!-- Robot SVG Icon -->
    <svg class="robot-icon" width="30" height="30" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
      <rect x="3" y="11" width="18" height="10" rx="4"></rect>
      <circle cx="12" cy="5" r="2"></circle>
      <path d="M12 7v4"></path>
      <line x1="8" y1="16" x2="8.01" y2="16" stroke-width="3" stroke="#F2C94C"></line>
      <line x1="16" y1="16" x2="16.01" y2="16" stroke-width="3" stroke="#F2C94C"></line>
      <path d="M9 19c1 .6 2 .9 3 .9s2-.3 3-.9" stroke="currentColor" stroke-width="1.5"></path>
      <path d="M2 14h1M21 14h1"></path>
    </svg>

    <!-- Close Icon (When open) -->
    <svg class="close-icon" width="26" height="26" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round" style="display: none;">
      <line x1="18" y1="6" x2="6" y2="18"></line>
      <line x1="6" y1="6" x2="18" y2="18"></line>
    </svg>
    
    <span class="chatbot-badge-text"><?= $isVi ? 'Hỏi AI' : 'Ask AI' ?></span>
  </button>

  <!-- Interactive Chat Window Modal -->
  <div id="chatbotModal" class="chatbot-modal" aria-hidden="true">
    
    <!-- Chat Header -->
    <div class="chatbot-header">
      <div class="chatbot-header-info">
        <div class="chatbot-avatar">
          <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="#FFF" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
            <rect x="3" y="11" width="18" height="10" rx="3"></rect>
            <circle cx="12" cy="5" r="2"></circle>
            <path d="M12 7v4"></path>
            <line x1="8" y1="16" x2="8.01" y2="16" stroke-width="3" stroke="#F2C94C"></line>
            <line x1="16" y1="16" x2="16.01" y2="16" stroke-width="3" stroke="#F2C94C"></line>
          </svg>
        </div>
        <div>
          <h4 class="chatbot-title"><?= $isVi ? 'Trợ Lý AI Du Lịch' : 'AI Travel Assistant' ?></h4>
          <span class="chatbot-status">
            <span class="chatbot-status-dot"></span>
            <?= $isVi ? 'Trực tuyến 24/7 · Vietnam Unique' : 'Online 24/7 · Vietnam Unique' ?>
          </span>
        </div>
      </div>
      <button id="chatbotCloseBtn" class="chatbot-header-close" aria-label="Close Chat">
        <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
          <line x1="18" y1="6" x2="6" y2="18"></line>
          <line x1="6" y1="6" x2="18" y2="18"></line>
        </svg>
      </button>
    </div>

    <!-- Chat Messages Feed -->
    <div id="chatbotMessages" class="chatbot-messages">
      <!-- Welcome Message from Bot -->
      <div class="chat-msg chat-msg-bot">
        <div class="chat-msg-avatar">🤖</div>
        <div class="chat-msg-bubble">
          <p>
            <?= $isVi 
              ? 'Xin chào! Em là Trợ lý AI của <strong>Vietnam Unique Travel</strong> 🌿. Em có thể gợi ý lịch trình, tư vấn tour Pù Luông, Mai Châu hoặc giúp bạn thiết kế chuyến đi riêng.' 
              : 'Xin chào! I am the AI Assistant of <strong>Vietnam Unique Travel</strong> 🌿. How may I assist you with tour itineraries, Pu Luong trekking, or tailor-made journeys in Vietnam?' 
            ?>
          </p>
          <span class="chat-msg-time"><?= date('H:i') ?></span>
        </div>
      </div>

      <!-- Quick Suggestion Chips -->
      <div class="chat-chips-wrap">
        <span class="chat-chips-label"><?= $isVi ? 'Gợi ý câu hỏi nhanh:' : 'Quick inquiries:' ?></span>
        <div class="chat-chips">
          <button type="button" class="chat-chip" data-query="<?= $isVi ? 'Tour Pù Luông có gì đặc sắc?' : 'What are the top Pu Luong tours?' ?>">
            🌾 <?= $isVi ? 'Tour Pù Luông đặc sắc' : 'Top Pu Luong Tours' ?>
          </button>
          <button type="button" class="chat-chip" data-query="<?= $isVi ? 'Tư vấn trekking đỉnh núi Pù Luông 1.700m' : 'Tell me about Pu Luong Peak Trekking' ?>">
            ⛰️ <?= $isVi ? 'Trekking đỉnh Pù Luông' : 'Peak Trekking' ?>
          </button>
          <button type="button" class="chat-chip" data-query="<?= $isVi ? 'Tôi muốn đặt tour riêng may đo' : 'How can I customize a private tour?' ?>">
            📅 <?= $isVi ? 'Đặt tour riêng (Private)' : 'Private Tour Inquiry' ?>
          </button>
          <button type="button" class="chat-chip" data-query="<?= $isVi ? 'Số điện thoại hotline và WhatsApp hỗ trợ' : 'What is your Hotline and WhatsApp?' ?>">
            📞 <?= $isVi ? 'Hotline & WhatsApp' : 'Hotline & WhatsApp' ?>
          </button>
        </div>
      </div>
    </div>

    <!-- Chat Input Form -->
    <form id="chatbotForm" class="chatbot-input-bar">
      <input 
        type="text" 
        id="chatbotInput" 
        class="chatbot-input" 
        placeholder="<?= $isVi ? 'Hỏi về tour, điểm đến, giá cả...' : 'Ask about tours, itineraries, advice...' ?>" 
        autocomplete="off"
        required
      >
      <button type="submit" class="chatbot-send-btn" aria-label="Send message">
        <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
          <line x1="22" y1="2" x2="11" y2="13"></line>
          <polygon points="22 2 15 22 11 13 2 9 22 2"></polygon>
        </svg>
      </button>
    </form>

  </div>
</div>

<script>
(function() {
  const isVi = <?= json_encode($isVi) ?>;
  const triggerBtn = document.getElementById('chatbotTriggerBtn');
  const modal = document.getElementById('chatbotModal');
  const closeBtn = document.getElementById('chatbotCloseBtn');
  const form = document.getElementById('chatbotForm');
  const input = document.getElementById('chatbotInput');
  const messagesBox = document.getElementById('chatbotMessages');
  const robotIcon = triggerBtn?.querySelector('.robot-icon');
  const closeIcon = triggerBtn?.querySelector('.close-icon');

  if (!triggerBtn || !modal) return;

  function toggleChat(open) {
    const shouldOpen = open !== undefined ? open : !modal.classList.contains('active');
    if (shouldOpen) {
      modal.classList.add('active');
      modal.setAttribute('aria-hidden', 'false');
      triggerBtn.classList.add('is-open');
      if (robotIcon) robotIcon.style.display = 'none';
      if (closeIcon) closeIcon.style.display = 'block';
      setTimeout(() => input && input.focus(), 250);
    } else {
      modal.classList.remove('active');
      modal.setAttribute('aria-hidden', 'true');
      triggerBtn.classList.remove('is-open');
      if (robotIcon) robotIcon.style.display = 'block';
      if (closeIcon) closeIcon.style.display = 'none';
    }
  }

  triggerBtn.addEventListener('click', () => toggleChat());
  if (closeBtn) closeBtn.addEventListener('click', () => toggleChat(false));

  // Quick Chips Click
  document.addEventListener('click', (e) => {
    const chip = e.target.closest('.chat-chip');
    if (chip) {
      const q = chip.getAttribute('data-query');
      if (q) handleUserQuery(q);
    }
  });

  // Handle Send Form
  if (form) {
    form.addEventListener('submit', (e) => {
      e.preventDefault();
      const text = input.value.trim();
      if (!text) return;
      handleUserQuery(text);
      input.value = '';
    });
  }

  function appendMessage(sender, text) {
    const timeStr = new Date().toLocaleTimeString([], { hour: '2-digit', minute: '2-digit' });
    const msgDiv = document.createElement('div');
    msgDiv.className = `chat-msg chat-msg-${sender}`;
    
    if (sender === 'user') {
      msgDiv.innerHTML = `
        <div class="chat-msg-bubble chat-msg-bubble-user">
          <p>${escapeHtml(text)}</p>
          <span class="chat-msg-time">${timeStr}</span>
        </div>
      `;
    } else {
      msgDiv.innerHTML = `
        <div class="chat-msg-avatar">🤖</div>
        <div class="chat-msg-bubble">
          <div>${text}</div>
          <span class="chat-msg-time">${timeStr}</span>
        </div>
      `;
    }

    messagesBox.appendChild(msgDiv);
    messagesBox.scrollTop = messagesBox.scrollHeight;
  }

  function handleUserQuery(query) {
    appendMessage('user', query);

    // Typing indicator
    const typingDiv = document.createElement('div');
    typingDiv.className = 'chat-msg chat-msg-bot chat-typing';
    typingDiv.innerHTML = `
      <div class="chat-msg-avatar">🤖</div>
      <div class="chat-msg-bubble">
        <div class="typing-dots"><span></span><span></span><span></span></div>
      </div>
    `;
    messagesBox.appendChild(typingDiv);
    messagesBox.scrollTop = messagesBox.scrollHeight;

    setTimeout(() => {
      typingDiv.remove();
      const reply = generateAiResponse(query);
      appendMessage('bot', reply);
    }, 600);
  }

  function generateAiResponse(q) {
    const text = q.toLowerCase();
    const prefix = isVi ? '/vi' : '';

    if (text.includes('pù luông') || text.includes('pu luong') || text.includes('tour')) {
      return isVi
        ? `Vietnam Unique Travel hiện có các tour Pù Luông nổi bật:<br>
           • <strong>Hidden Villages & Hieu Waterfall</strong> (Khám phá bản Son Bá Mười & Thác Hiêu)<br>
           • <strong>Summit Expedition</strong> (Chinh phục đỉnh Pù Luông 1.700m)<br>
           • <strong>Water Wheels & Bamboo Rafting</strong> (Guồng nước khổng lồ & Bè tre suối Chàm)<br><br>
           👉 <a href="${prefix}/tours" class="chat-link">Xem tất cả 12 Tour Pù Luông & Miền Bắc →</a>`
        : `Vietnam Unique Travel offers exceptional handcrafted journeys:<br>
           • <strong>Hidden Villages & Hieu Waterfall Adventure</strong><br>
           • <strong>Summit Expedition: Conquer Pu Luong Peak (1,700m)</strong><br>
           • <strong>Cham River Bamboo Rafting & Water Wheels</strong><br><br>
           👉 <a href="/tours" class="chat-link">Explore all 12 Signature Tours →</a>`;
    }

    if (text.includes('trekking') || text.includes('leo núi') || text.includes('đỉnh') || text.includes('peak')) {
      return isVi
        ? `Hành trình chinh phục <strong>Đỉnh Pù Luông 1.700m</strong> đi xuyên qua rừng nguyên sinh, thưởng thức BBQ trên đỉnh và ngâm chân thảo dược truyền thống Thái.<br><br>
           👉 <a href="${prefix}/tours/puluong-peak-trekking" class="chat-link">Xem chi tiết Tour Trekking →</a>`
        : `Our <strong>Pu Luong Peak (1,700m) Summit Trek</strong> crosses untouched jungle canopy with a scenic summit BBQ and restorative herbal foot soak.<br><br>
           👉 <a href="/tours/puluong-peak-trekking" class="chat-link">View Trekking Itinerary →</a>`;
    }

    if (text.includes('đặt') || text.includes('book') || text.includes('private') || text.includes('riêng') || text.includes('may đo') || text.includes('custom')) {
      return isVi
        ? `Bạn có thể gửi yêu cầu đặt tour hoặc may đo lịch trình trực tiếp qua form trực tuyến, đội ngũ tư vấn sẽ phản hồi trong ít phút!<br><br>
           👉 <a href="${prefix}/booking" class="chat-link">Mở Phiếu Đặt Tour / Báo Giá →</a>`
        : `You can submit a booking request or custom itinerary inquiry directly via our online form. Our travel specialists will respond within minutes!<br><br>
           👉 <a href="/booking" class="chat-link">Open Booking & Inquiry Form →</a>`;
    }

    if (text.includes('hotline') || text.includes('liên hệ') || text.includes('phone') || text.includes('whatsapp') || text.includes('sdt') || text.includes('contact')) {
      return isVi
        ? `Đội ngũ tư vấn sẵn sàng hỗ trợ bạn 24/7:<br>
           📞 Hotline: <strong>+84 (0) 362 191 568</strong><br>
           💬 WhatsApp: <a href="https://wa.me/84362191568" target="_blank" class="chat-link">+84 362 191 568</a><br>
           ✉️ Email: <strong>sales.vietnamuniquetravel@gmail.com</strong>`
        : `Our travel experts are available 24/7 to support you:<br>
           📞 Hotline: <strong>+84 (0) 362 191 568</strong><br>
           💬 WhatsApp: <a href="https://wa.me/84362191568" target="_blank" class="chat-link">Chat on WhatsApp</a><br>
           ✉️ Email: <strong>sales.vietnamuniquetravel@gmail.com</strong>`;
    }

    return isVi
      ? `Cảm ơn bạn đã nhắn tin! Để nhận tư vấn chi tiết và báo giá nhanh nhất, bạn có thể gọi hotline <a href="tel:+84362191568" class="chat-link">+84 362 191 568</a> hoặc gửi yêu cầu qua form đặt tour nhé!<br><br>
         👉 <a href="${prefix}/booking" class="chat-link">Gửi Yêu Cầu Tư Vấn Tour →</a>`
      : `Thank you for your message! To receive instant assistance or customized quotes, feel free to call our hotline <a href="tel:+84362191568" class="chat-link">+84 362 191 568</a> or submit an inquiry.<br><br>
         👉 <a href="/booking" class="chat-link">Submit Tour Inquiry →</a>`;
  }

  function escapeHtml(str) {
    return str.replace(/[&<>"']/g, function(m) {
      return ({ '&': '&amp;', '<': '&lt;', '>': '&gt;', '"': '&quot;', "'": '&#039;' })[m];
    });
  }
})();
</script>
