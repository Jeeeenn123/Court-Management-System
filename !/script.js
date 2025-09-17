document.addEventListener('DOMContentLoaded', () => {
  // --- Sidebar: Keep active link on reload ---
  const savedIndex = localStorage.getItem('activeSidebarIndex');
  const sidebarItems = document.querySelectorAll('.sidebar ul li');

  if (savedIndex !== null && sidebarItems[savedIndex]) {
    sidebarItems.forEach(i => i.classList.remove('active'));
    sidebarItems[savedIndex].classList.add('active');
  }

  // Add click listeners to sidebar items
  sidebarItems.forEach((item, index) => {
    item.addEventListener('click', () => {
      sidebarItems.forEach(i => i.classList.remove('active'));
      item.classList.add('active');
      localStorage.setItem('activeSidebarIndex', index);
    });
  });

  // --- Time Dropdown (12-Hour AM/PM Format) ---
  const courtHeader = document.querySelector('.availability h2');
  if (courtHeader) {
    const timeDropdown = document.createElement('select');

    for (let hour = 8; hour <= 22; hour++) {
      const option = document.createElement('option');
      const hour12 = hour % 12 === 0 ? 12 : hour % 12;
      const period = hour < 12 ? 'AM' : 'PM';
      const displayTime = `${hour12}:00 ${period}`;
      const valueTime = `${hour.toString().padStart(2, '0')}:00`;

      option.value = valueTime;
      option.textContent = displayTime;
      timeDropdown.appendChild(option);
    }

    Object.assign(timeDropdown.style, {
      marginLeft: '20px',
      padding: '6px',
      borderRadius: '6px',
      border: '1px solid #ccc',
      fontSize: '14px'
    });

    timeDropdown.addEventListener('change', (e) => {
      alert(`Selected time: ${e.target.options[e.target.selectedIndex].text}`);
      // Future: AJAX/PHP logic can go here
    });

    courtHeader.appendChild(timeDropdown);
  }

  // --- Animate Metrics Cards on Load ---
  const cards = document.querySelectorAll('.card');
  cards.forEach((card, i) => {
    card.style.opacity = 0;
    card.style.transform = 'translateY(20px)';
    setTimeout(() => {
      card.style.transition = '0.4s ease';
      card.style.opacity = 1;
      card.style.transform = 'translateY(0)';
    }, i * 100);
  });
});
