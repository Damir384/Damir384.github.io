function showMenu(menuId) {
  var menus = document.querySelectorAll('div[id^="menu"]');
  menus.forEach(function(menu) {
    if (menu.id === menuId) {
      menu.style.display = "block";
    } else {
      menu.style.display = "none";
    }
  });
}

// Изначально скрываем все меню, кроме первого
showMenu('menu1');