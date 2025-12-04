// ============================================
// RESERVATECH - Sistema Futurístico de Reservas
// Efeitos Interativos e Animações Avançadas
// ============================================

// Função para inicializar a página
document.addEventListener("DOMContentLoaded", function () {
  initializeFilters();
  initializeTabs();
  initializeSearch();
  initializeAnimations();
  initializeParticleEffects();
  initializeTypewriter();
  initializeParallax();
  initializeSoundEffects();
  initializeMobileMenu();
  initializeNavigationHistory();
  initializeBackButtons();
});

// Cache simples de localização para evitar múltiplas prompts
let cachedLocation = null;

// ============================================
// MENU MOBILE
// ============================================
function initializeMobileMenu() {
  const mobileMenuToggle = document.getElementById("mobileMenuToggle");
  const nav = document.getElementById("mainNav");

  if (mobileMenuToggle && nav) {
    mobileMenuToggle.addEventListener("click", function () {
      this.classList.toggle("active");
      nav.classList.toggle("active");

      // Prevenir scroll quando menu está aberto
      if (nav.classList.contains("active")) {
        document.body.style.overflow = "hidden";
      } else {
        document.body.style.overflow = "";
      }
    });

    // Fechar menu ao clicar em um link
    const navLinks = nav.querySelectorAll("a");
    navLinks.forEach((link) => {
      link.addEventListener("click", function () {
        mobileMenuToggle.classList.remove("active");
        nav.classList.remove("active");
        document.body.style.overflow = "";
      });
    });

    // Fechar menu ao clicar fora
    document.addEventListener("click", function (e) {
      if (!nav.contains(e.target) && !mobileMenuToggle.contains(e.target)) {
        mobileMenuToggle.classList.remove("active");
        nav.classList.remove("active");
        document.body.style.overflow = "";
      }
    });
  }
}

// ============================================
// ANIMAÇÕES INICIAIS
// ============================================
function initializeAnimations() {
  // Animar cards ao entrar na viewport
  const observerOptions = {
    threshold: 0.1,
    rootMargin: "0px 0px -50px 0px",
  };

  const observer = new IntersectionObserver(function (entries) {
    entries.forEach((entry, index) => {
      if (entry.isIntersecting) {
        setTimeout(() => {
          entry.target.style.opacity = "1";
          entry.target.style.transform = "translateY(0)";
        }, index * 100);
        observer.unobserve(entry.target);
      }
    });
  }, observerOptions);

  // Observar cards de restaurantes
  document.querySelectorAll(".restaurant-card").forEach((card, index) => {
    card.style.opacity = "0";
    card.style.transform = "translateY(30px)";
    card.style.transition = "all 0.6s ease-out";
    observer.observe(card);
  });

  // Observar menu items
  document.querySelectorAll(".menu-item").forEach((item, index) => {
    item.style.opacity = "0";
    item.style.transform = "translateX(-20px)";
    item.style.transition = "all 0.5s ease-out";
    observer.observe(item);
  });

  // Observar review cards
  document.querySelectorAll(".review-card").forEach((card, index) => {
    card.style.opacity = "0";
    card.style.transform = "translateX(20px)";
    card.style.transition = "all 0.5s ease-out";
    observer.observe(card);
  });
}

// ============================================
// EFEITOS DE PARTÍCULAS
// ============================================
function initializeParticleEffects() {
  const searchBtn = document.getElementById("searchBtn");
  const heroBtn = document.querySelector(".hero-section .btn");

  function createParticle(x, y, element) {
    const particle = document.createElement("div");
    particle.style.position = "fixed";
    particle.style.left = x + "px";
    particle.style.top = y + "px";
    particle.style.width = "4px";
    particle.style.height = "4px";
    particle.style.background = "#ff6b35";
    particle.style.borderRadius = "50%";
    particle.style.pointerEvents = "none";
    particle.style.zIndex = "9999";
    particle.style.boxShadow = "0 0 10px #ff6b35, 0 0 20px #ff6b35";

    document.body.appendChild(particle);

    const angle = Math.random() * Math.PI * 2;
    const velocity = 2 + Math.random() * 3;
    const vx = Math.cos(angle) * velocity;
    const vy = Math.sin(angle) * velocity;

    let px = x;
    let py = y;
    let opacity = 1;

    function animate() {
      px += vx;
      py += vy;
      opacity -= 0.02;

      particle.style.left = px + "px";
      particle.style.top = py + "px";
      particle.style.opacity = opacity;

      if (opacity > 0) {
        requestAnimationFrame(animate);
      } else {
        particle.remove();
      }
    }

    animate();
  }

  if (searchBtn) {
    searchBtn.addEventListener("click", function (e) {
      const rect = this.getBoundingClientRect();
      const x = rect.left + rect.width / 2;
      const y = rect.top + rect.height / 2;

      for (let i = 0; i < 20; i++) {
        setTimeout(() => {
          createParticle(x, y, this);
        }, i * 10);
      }
    });
  }

  if (heroBtn) {
    heroBtn.addEventListener("click", function (e) {
      const rect = this.getBoundingClientRect();
      const x = rect.left + rect.width / 2;
      const y = rect.top + rect.height / 2;

      for (let i = 0; i < 30; i++) {
        setTimeout(() => {
          createParticle(x, y, this);
        }, i * 8);
      }
    });
  }
}

// ============================================
// EFEITO TYPEWRITER NO HERO
// ============================================
function initializeTypewriter() {
  const heroTitle = document.querySelector(".hero-section h1");
  if (heroTitle) {
    const text = heroTitle.textContent;
    heroTitle.textContent = "";
    heroTitle.style.opacity = "1";

    let i = 0;
    function typeWriter() {
      if (i < text.length) {
        heroTitle.textContent += text.charAt(i);
        i++;
        setTimeout(typeWriter, 50);
      }
    }

    // Iniciar após um pequeno delay
    setTimeout(typeWriter, 300);
  }
}

// ============================================
// EFEITO PARALLAX
// ============================================
function initializeParallax() {
  const heroSection = document.querySelector(".hero-section");

  if (heroSection) {
    window.addEventListener("scroll", function () {
      const scrolled = window.pageYOffset;
      const rate = scrolled * 0.5;

      if (scrolled < heroSection.offsetHeight) {
        heroSection.style.transform = `translateY(${rate}px)`;
        heroSection.style.opacity =
          1 - (scrolled / heroSection.offsetHeight) * 0.5;
      }
    });
  }
}

// ============================================
// EFEITOS SONOROS (OPCIONAL - Pode ser removido)
// ============================================
function initializeSoundEffects() {
  // Efeito visual de "beep" através de animação
  const buttons = document.querySelectorAll(
    ".btn, .filter-chip, .smart-filter-item"
  );

  buttons.forEach((button) => {
    button.addEventListener("click", function () {
      // Efeito visual de "pulse"
      this.style.transform = "scale(0.95)";
      setTimeout(() => {
        this.style.transform = "";
      }, 150);
    });
  });
}

// ============================================
// INICIALIZAR FILTROS
// ============================================
function initializeFilters() {
  const filterChips = document.querySelectorAll(".filter-chip:not(select)");
  filterChips.forEach((chip) => {
    chip.addEventListener("click", function () {
      this.classList.toggle("active");
      createRippleEffect(this);
      applyFilters();
    });
  });

  const smartFilters = document.querySelectorAll(".smart-filter-item");
  smartFilters.forEach((filter) => {
    filter.addEventListener("click", function () {
      this.classList.toggle("active");
      createRippleEffect(this);
      applyFilters();
    });
  });

  const selectFilters = document.querySelectorAll(".filter-select");
  selectFilters.forEach((select) => {
    select.addEventListener("change", function () {
      createRippleEffect(this);
      // Se for o filtro de cidade, buscar características disponíveis para essa cidade,
      // reconstruir os filtros inteligentes e então aplicar os filtros.
      if (this.id === "cityFilter") {
        const city = this.value;
        fetchCharacteristicsForCity(city)
          .then(() => {
            applyFilters();
          })
          .catch(() => {
            applyFilters();
          });
      } else {
        applyFilters();
      }
    });
  });
}

// Busca as características disponíveis para uma cidade e reconstrói os botões de filtros inteligentes
function fetchCharacteristicsForCity(city) {
  return new Promise((resolve, reject) => {
    const url =
      "/crud-hackaton/controller/filtersController.php?cidade=" +
      encodeURIComponent(city);
    fetch(url, { headers: { "X-Requested-With": "XMLHttpRequest" } })
      .then((resp) => {
        if (!resp.ok) throw new Error("Erro ao buscar características");
        return resp.json();
      })
      .then((data) => {
        if (!data.success) throw new Error(data.error || "Resposta inválida");

        const container = document.querySelector(".smart-filters-grid");
        if (!container) return resolve();

        // Preservar seleção atual (ids)
        const selected = Array.from(
          document.querySelectorAll(".smart-filter-item.active")
        )
          .map((btn) => btn.getAttribute("data-id"))
          .filter(Boolean);

        // Construir novos botões (attach handlers diretamente para evitar múltiplos binds)
        container.innerHTML = "";
        data.caracteristicas.forEach((carac) => {
          const btn = document.createElement("button");
          btn.type = "button";
          btn.className = "smart-filter-item";
          btn.setAttribute("data-id", carac.id);
          btn.innerHTML = "<span>" + escapeHtml(carac.nome) + "</span>";
          if (selected.includes(String(carac.id))) {
            btn.classList.add("active");
            btn.style.background = "var(--primary-neon)";
            btn.style.color = "white";
          }

          // Adicionar listener direto
          btn.addEventListener("click", function (e) {
            e.preventDefault();
            this.classList.toggle("active");
            createRippleEffect(this);
            applyFilters();
          });

          container.appendChild(btn);
        });

        resolve();
      })
      .catch((err) => {
        console.error("Erro ao buscar características:", err);
        reject(err);
      });
  });
}

function escapeHtml(text) {
  return (text + "").replace(/[&<>"'`]/g, function (m) {
    return {
      "&": "&amp;",
      "<": "&lt;",
      ">": "&gt;",
      '"': "&quot;",
      "'": "&#39;",
      "`": "&#96;",
    }[m];
  });
}

// ============================================
// EFEITO RIPPLE (ONDA)
// ============================================
function createRippleEffect(element) {
  const ripple = document.createElement("span");
  const rect = element.getBoundingClientRect();
  const size = Math.max(rect.width, rect.height);
  const x = event.clientX - rect.left - size / 2;
  const y = event.clientY - rect.top - size / 2;

  ripple.style.width = ripple.style.height = size + "px";
  ripple.style.left = x + "px";
  ripple.style.top = y + "px";
  ripple.classList.add("ripple");

  // Adicionar estilos de ripple
  ripple.style.position = "absolute";
  ripple.style.borderRadius = "50%";
  ripple.style.background = "rgba(255, 107, 53, 0.5)";
  ripple.style.transform = "scale(0)";
  ripple.style.animation = "ripple 0.6s ease-out";
  ripple.style.pointerEvents = "none";

  element.style.position = "relative";
  element.style.overflow = "hidden";
  element.appendChild(ripple);

  setTimeout(() => ripple.remove(), 600);
}

// Adicionar animação de ripple ao CSS via JavaScript
const style = document.createElement("style");
style.textContent = `
    @keyframes ripple {
        to {
            transform: scale(4);
            opacity: 0;
        }
    }
`;
document.head.appendChild(style);

// ============================================
// APLICAR FILTROS E BUSCAR RESTAURANTES
// ============================================
function applyFilters() {
  const searchInput = document.getElementById("searchInput");
  const searchTerm = searchInput ? searchInput.value : "";

  // Mostrar loading effect
  showLoadingEffect();

  // Construir parâmetros da requisição com os filtros atuais
  const params = new URLSearchParams();
  if (searchTerm) params.append("q", searchTerm);

  const cityFilter = document.getElementById("cityFilter");
  if (cityFilter && cityFilter.value) params.append("cidade", cityFilter.value);

  const activeSmart = Array.from(
    document.querySelectorAll(".smart-filter-item.active")
  )
    .map((btn) => btn.getAttribute("data-id"))
    .filter(Boolean);

  activeSmart.forEach((id) => params.append("caracteristicas[]", id));
  const distanceBtn = document.getElementById("distanceFilter");
  const nearestActive = distanceBtn && distanceBtn.classList.contains("active");

  function doFetch(finalParams) {
    const url =
      "/crud-hackaton/controller/searchController.php?" +
      finalParams.toString();
    console.log("Fetching", url);
    fetch(url, { headers: { "X-Requested-With": "XMLHttpRequest" } })
      .then((resp) => {
        console.log("Fetch response status", resp.status);
        if (!resp.ok)
          throw new Error("Erro ao buscar restaurantes: " + resp.status);
        return resp.text();
      })
      .then((html) => {
        const grid = document.getElementById("restaurantsGrid");
        if (grid) {
          grid.innerHTML = html;
        }

        // Atualizar URL sem recarregar
        const newUrl =
          window.location.pathname +
          (finalParams.toString() ? "?" + finalParams.toString() : "");
        try {
          window.history.pushState({}, "", newUrl);
        } catch (e) {
          console.warn("pushState falhou", e);
        }

        // Reaplicar interações/efeitos aos novos elementos
        initializeAnimations();
        initializeBackButtons();
      })
      .catch((err) => {
        console.error(err);
      })
      .finally(() => {
        hideLoadingEffect();
      });
  }

  if (nearestActive) {
    // Se o usuário quer 'mais próximo', obter localização antes do fetch
    getLocation()
      .then((coords) => {
        if (coords && coords.lat && coords.lng) {
          params.append("lat", coords.lat);
          params.append("lng", coords.lng);
          params.append("nearest", "1");
        }
        doFetch(params);
      })
      .catch((err) => {
        console.warn("Não foi possível obter localização:", err);
        // Fazer busca sem coords
        doFetch(params);
      });
  } else {
    doFetch(params);
  }
}

// ============================================
// EFEITO DE LOADING
// ============================================
function showLoadingEffect() {
  const restaurantsGrid = document.getElementById("restaurantsGrid");
  if (!restaurantsGrid) return;

  const loading = document.createElement("div");
  loading.id = "loading-effect";
  loading.style.cssText = `
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background: rgba(10, 10, 15, 0.8);
        backdrop-filter: blur(10px);
        display: flex;
        align-items: center;
        justify-content: center;
        z-index: 100;
        border-radius: 20px;
    `;

  const spinner = document.createElement("div");
  spinner.style.cssText = `
        width: 60px;
        height: 60px;
        border: 4px solid rgba(255, 107, 53, 0.2);
        border-top-color: #ff6b35;
        border-radius: 50%;
        animation: spin 1s linear infinite;
    `;

  loading.appendChild(spinner);

  // Adicionar animação de spin
  if (!document.querySelector("#spin-animation")) {
    const spinStyle = document.createElement("style");
    spinStyle.id = "spin-animation";
    spinStyle.textContent = `
            @keyframes spin {
                to { transform: rotate(360deg); }
            }
        `;
    document.head.appendChild(spinStyle);
  }

  restaurantsGrid.style.position = "relative";
  restaurantsGrid.appendChild(loading);
}

function hideLoadingEffect() {
  const loading = document.getElementById("loading-effect");
  if (loading) {
    loading.style.opacity = "0";
    loading.style.transition = "opacity 0.3s";
    setTimeout(() => loading.remove(), 300);
  }
}

// ============================================
// OBTER FILTROS ATIVOS
// ============================================
function getActiveFilters() {
  const activeChips = Array.from(
    document.querySelectorAll(".filter-chip.active")
  ).map((chip) => chip.textContent.trim());

  const activeSmartFilters = Array.from(
    document.querySelectorAll(".smart-filter-item.active")
  ).map((filter) => filter.querySelector("span").textContent.trim());

  const cityFilter = document.getElementById("cityFilter");
  const distanceFilter = document.getElementById("distanceFilter");

  return {
    chips: activeChips,
    smartFilters: activeSmartFilters,
    city: cityFilter ? cityFilter.value : "",
    distance: distanceFilter ? distanceFilter.value : "",
  };
}

// ============================================
// FILTRAR RESTAURANTES
// ============================================
function filterRestaurants() {
  const restaurantCards = document.querySelectorAll(".restaurant-card");
  const filters = getActiveFilters();
  const searchInput = document.getElementById("searchInput");
  const searchTerm = searchInput ? searchInput.value.toLowerCase() : "";

  restaurantCards.forEach((card, index) => {
    let shouldShow = true;

    // Busca por texto
    if (searchTerm) {
      const cardText = card.textContent.toLowerCase();
      if (!cardText.includes(searchTerm)) {
        shouldShow = false;
      }
    }

    // Aplicar filtros aqui (lógica específica)
    // Por enquanto, apenas aplica a busca

    // Animação de fade in/out
    if (shouldShow) {
      setTimeout(() => {
        card.style.display = "block";
        card.style.opacity = "0";
        card.style.transform = "scale(0.9)";
        setTimeout(() => {
          card.style.transition = "all 0.3s ease-out";
          card.style.opacity = "1";
          card.style.transform = "scale(1)";
        }, 50);
      }, index * 50);
    } else {
      card.style.transition = "all 0.3s ease-out";
      card.style.opacity = "0";
      card.style.transform = "scale(0.9)";
      setTimeout(() => {
        card.style.display = "none";
      }, 300);
    }
  });
}

// ============================================
// INICIALIZAR SISTEMA DE ABAS
// ============================================
function initializeTabs() {
  const tabs = document.querySelectorAll(".tab");
  const tabContents = document.querySelectorAll(".tab-content");

  tabs.forEach((tab) => {
    tab.addEventListener("click", function () {
      const targetTab = this.getAttribute("data-tab");

      // Efeito visual
      createRippleEffect(this);

      // Remover active de todas as abas
      tabs.forEach((t) => t.classList.remove("active"));
      tabContents.forEach((content) => {
        content.classList.remove("active");
        content.style.opacity = "0";
        content.style.transform = "translateY(10px)";
      });

      // Adicionar active na aba clicada
      this.classList.add("active");
      const targetContent = document.getElementById(targetTab);
      if (targetContent) {
        setTimeout(() => {
          targetContent.classList.add("active");
          targetContent.style.opacity = "1";
          targetContent.style.transform = "translateY(0)";
        }, 100);
      }
    });
  });
}

// ============================================
// INICIALIZAR BUSCA
// ============================================
function initializeSearch() {
  const searchBtn = document.getElementById("searchBtn");
  const searchInput = document.getElementById("searchInput");

  if (searchBtn) {
    searchBtn.addEventListener("click", function (e) {
      e.preventDefault();
      createRippleEffect(this);
      performSearch();
    });
  }

  // Interceptar submit nativo do formulário de busca (para prevenir reload)
  const searchForm = document.getElementById("searchForm");
  if (searchForm) {
    searchForm.addEventListener("submit", function (e) {
      e.preventDefault();
      performSearch();
    });
  }

  if (searchInput) {
    // Busca em tempo real enquanto digita
    let searchTimeout;
    searchInput.addEventListener("input", function () {
      clearTimeout(searchTimeout);
      searchTimeout = setTimeout(() => {
        applyFilters();
      }, 500);
    });

    searchInput.addEventListener("keypress", function (e) {
      if (e.key === "Enter") {
        e.preventDefault();
        performSearch();
      }
    });
  }
}

// ============================================
// REALIZAR BUSCA
// ============================================
function performSearch() {
  const searchInput = document.getElementById("searchInput");
  const searchTerm = searchInput ? searchInput.value : "";

  if (searchTerm.trim() === "") {
    // Mostrar notificação futurística
    showNotification("Por favor, digite um termo de busca", "warning");
    return;
  }

  applyFilters();
}

// ============================================
// SISTEMA DE NOTIFICAÇÕES
// ============================================
function showNotification(message, type = "info") {
  const notification = document.createElement("div");
  notification.style.cssText = `
        position: fixed;
        top: 20px;
        right: 20px;
        padding: 1.5rem 2rem;
        background: rgba(18, 18, 26, 0.95);
        backdrop-filter: blur(20px);
        border: 2px solid ${type === "warning" ? "#ff8c42" : "#ff6b35"};
        border-radius: 15px;
        color: #ffffff;
        font-family: 'Poppins', sans-serif;
        font-weight: 600;
        font-size: 1.1rem;
        z-index: 10000;
        box-shadow: 0 0 30px ${
          type === "warning"
            ? "rgba(255, 140, 66, 0.5)"
            : "rgba(255, 107, 53, 0.5)"
        };
        animation: slideInRight 0.3s ease-out;
        max-width: 400px;
    `;

  notification.textContent = message;
  document.body.appendChild(notification);

  // Adicionar animação
  if (!document.querySelector("#slide-in-right")) {
    const animStyle = document.createElement("style");
    animStyle.id = "slide-in-right";
    animStyle.textContent = `
            @keyframes slideInRight {
                from {
                    transform: translateX(100%);
                    opacity: 0;
                }
                to {
                    transform: translateX(0);
                    opacity: 1;
                }
            }
        `;
    document.head.appendChild(animStyle);
  }

  setTimeout(() => {
    notification.style.transition = "all 0.3s ease-out";
    notification.style.opacity = "0";
    notification.style.transform = "translateX(100%)";
    setTimeout(() => notification.remove(), 300);
  }, 3000);
}

// ============================================
// SISTEMA DE HISTÓRICO DE NAVEGAÇÃO
// ============================================

// Salvar página atual no histórico ao carregar
function initializeNavigationHistory() {
  // Salvar página atual se não for uma navegação interna
  const currentPage = window.location.pathname + window.location.search;
  const history = JSON.parse(
    sessionStorage.getItem("navigationHistory") || "[]"
  );

  // Só adicionar se não for a última página salva
  if (history.length === 0 || history[history.length - 1] !== currentPage) {
    history.push(currentPage);
    // Manter apenas as últimas 10 páginas
    if (history.length > 10) {
      history.shift();
    }
    sessionStorage.setItem("navigationHistory", JSON.stringify(history));
  }
}

// Função para navegar salvando histórico
function navigateTo(url) {
  const currentPage = window.location.pathname + window.location.search;
  const history = JSON.parse(
    sessionStorage.getItem("navigationHistory") || "[]"
  );

  // Adicionar página atual ao histórico antes de navegar
  if (history.length === 0 || history[history.length - 1] !== currentPage) {
    history.push(currentPage);
    if (history.length > 10) {
      history.shift();
    }
    sessionStorage.setItem("navigationHistory", JSON.stringify(history));
  }

  window.location.href = url;
}

// Função para voltar à página anterior
function goBack() {
  const history = JSON.parse(
    sessionStorage.getItem("navigationHistory") || "[]"
  );

  if (history.length > 1) {
    // Remover página atual do histórico
    history.pop();
    const previousPage = history[history.length - 1];
    sessionStorage.setItem("navigationHistory", JSON.stringify(history));

    // Navegar para página anterior
    window.location.href = previousPage;
  } else {
    // Se não houver histórico, voltar para home
    const currentPath = window.location.pathname;
    if (currentPath.includes("/cliente/")) {
      window.location.href = "home.php";
    } else if (currentPath.includes("/restaurante/")) {
      window.location.href = "dashboard.php";
    } else {
      window.location.href = "../../index.php";
    }
  }
}

// Inicializar botões de voltar
function initializeBackButtons() {
  // Interceptar cliques em links que navegam (apenas para links internos)
  document.addEventListener("click", function (e) {
    const target = e.target.closest("a[href]");

    if (target && target.tagName === "A") {
      const href = target.getAttribute("href");

      // Verificar se é um link interno (não externo, não âncora, não javascript)
      if (
        href &&
        !href.startsWith("http") &&
        !href.startsWith("//") &&
        !href.startsWith("#") &&
        !href.startsWith("javascript:") &&
        !href.startsWith("mailto:") &&
        !href.startsWith("tel:")
      ) {
        // Verificar se não é um link de voltar ou cancelar
        if (!target.classList.contains("btn-back") && !target.onclick) {
          e.preventDefault();
          navigateTo(href);
        }
      }
    }
  });

  // Interceptar cliques em cards de restaurante
  document
    .querySelectorAll(
      '.restaurant-card[data-href], .restaurant-card[onclick*="location"]'
    )
    .forEach((card) => {
      const dataHref = card.getAttribute("data-href");
      const originalOnclick = card.getAttribute("onclick");

      if (originalOnclick) {
        card.removeAttribute("onclick");
      }

      card.style.cursor = "pointer";

      card.addEventListener("click", function (e) {
        // Verificar se o clique foi em um botão dentro do card
        if (e.target.closest(".btn")) {
          return; // Deixar o botão funcionar normalmente
        }

        let url = dataHref;

        if (!url && originalOnclick) {
          const match = originalOnclick.match(
            /window\.location\.href\s*=\s*['"]([^'"]+)['"]/
          );
          if (match) {
            url = match[1];
          }
        }

        if (url) {
          e.preventDefault();
          navigateTo(url);
        }
      });
    });
}

// ============================================
// FUNÇÕES DE NAVEGAÇÃO
// ============================================

// Função para fazer reserva
function makeReservation(restaurantId) {
  showNotification("Redirecionando para página de reserva...", "info");
  setTimeout(() => {
    navigateTo(`detalhes.php?id=${restaurantId}`);
  }, 500);
}

// Função para ver cardápio
function viewMenu(restaurantId) {
  const menuTab = document.querySelector('[data-tab="menu"]');
  if (menuTab) {
    menuTab.click();
  }
}

// Função para ver avaliações
function viewReviews(restaurantId) {
  const reviewsTab = document.querySelector('[data-tab="reviews"]');
  if (reviewsTab) {
    reviewsTab.click();
  }
}

// Função para submeter formulário de reserva
function submitReservation(event) {
  event.preventDefault();

  const formData = new FormData(event.target);
  const reservationData = {
    restaurantId: formData.get("restaurant_id"),
    date: formData.get("date"),
    time: formData.get("time"),
    guests: formData.get("guests"),
    specialRequests: formData.get("special_requests"),
  };

  // Mostrar loading
  const submitBtn = event.target.querySelector('button[type="submit"]');
  const originalText = submitBtn.textContent;
  submitBtn.textContent = "PROCESSANDO...";
  submitBtn.disabled = true;

  // Simular envio (remover em produção)
  setTimeout(() => {
    console.log("Criando reserva:", reservationData);
    showNotification("Reserva realizada com sucesso! ⚡", "success");

    submitBtn.textContent = originalText;
    submitBtn.disabled = false;

    setTimeout(() => {
      navigateTo("reservas.php");
    }, 1500);
  }, 1500);
}

// Função para cancelar reserva
function cancelReservation(reservationId) {
  // Criar modal futurístico de confirmação
  if (confirm("Tem certeza que deseja cancelar esta reserva?")) {
    showNotification("Cancelando reserva...", "info");

    setTimeout(() => {
      console.log("Cancelando reserva:", reservationId);
      showNotification("Reserva cancelada com sucesso!", "success");

      setTimeout(() => {
        location.reload();
      }, 1000);
    }, 1000);
  }
}

// ============================================
// GEOLOCALIZAÇÃO
// ============================================
function getLocation() {
  return new Promise((resolve, reject) => {
    if (cachedLocation && Date.now() - cachedLocation.ts < 5 * 60 * 1000) {
      return resolve(cachedLocation.coords);
    }

    if (!navigator.geolocation) {
      showNotification(
        "Geolocalização não é suportada pelo seu navegador.",
        "warning"
      );
      return reject(new Error("Geolocalização não suportada"));
    }

    showNotification("Obtendo sua localização...", "info");

    navigator.geolocation.getCurrentPosition(
      function (position) {
        const lat = position.coords.latitude;
        const lng = position.coords.longitude;
        console.log("Localização obtida:", lat, lng);
        showNotification("Localização obtida com sucesso!", "success");
        cachedLocation = { coords: { lat, lng }, ts: Date.now() };
        resolve({ lat, lng });
      },
      function (error) {
        console.error("Erro ao obter localização:", error);
        showNotification(
          "Não foi possível obter sua localização. Verifique as permissões.",
          "warning"
        );
        reject(error);
      },
      { enableHighAccuracy: false, timeout: 10000, maximumAge: 60000 }
    );
  });
}

// (Removido: listener de change redundante para distanceFilter)

// ============================================
// EFEITOS DE HOVER AVANÇADOS
// ============================================
document.addEventListener("DOMContentLoaded", function () {
  // Efeito de brilho nos cards
  const cards = document.querySelectorAll(
    ".restaurant-card, .menu-item, .review-card"
  );

  cards.forEach((card) => {
    card.addEventListener("mousemove", function (e) {
      const rect = this.getBoundingClientRect();
      const x = e.clientX - rect.left;
      const y = e.clientY - rect.top;

      const centerX = rect.width / 2;
      const centerY = rect.height / 2;

      const angleX = (y - centerY) / 10;
      const angleY = (centerX - x) / 10;

      this.style.transform = `perspective(1000px) rotateX(${angleX}deg) rotateY(${angleY}deg) translateY(-10px)`;
    });

    card.addEventListener("mouseleave", function () {
      this.style.transform = "";
    });
  });
});

async function submitReservation(event) {
  event.preventDefault();

  const form = document.getElementById("reservationForm");
  if (!form) {
    console.error("Formulário de reserva não encontrado");
    return;
  }

  const formData = new FormData(form);

  // Mostrar loading
  const submitBtn = form.querySelector('button[type="submit"]');
  const originalText = submitBtn.textContent;
  submitBtn.textContent = "PROCESSANDO...";
  submitBtn.disabled = true;

  try {
    // Usar caminho absoluto baseado na estrutura do projeto
    const controllerPath = "/crud-hackaton/controller/reservaController.php";
    const response = await fetch(controllerPath, {
      method: "POST",
      body: formData,
      headers: {
        "X-Requested-With": "XMLHttpRequest",
      },
    });

    // Verificar se a resposta é JSON
    const contentType = response.headers.get("content-type");
    if (!contentType || !contentType.includes("application/json")) {
      const text = await response.text();
      console.error("Resposta não é JSON:", text);
      throw new Error(
        "Resposta inválida do servidor. Verifique o console para mais detalhes."
      );
    }

    const result = await response.json();

    if (result.success) {
      showNotification("Reserva realizada com sucesso! ⚡", "success");
      form.reset();
      setTimeout(() => {
        window.location.href = "reservas.php";
      }, 1500);
    } else {
      showNotification(
        "Erro: " + (result.error || "Erro ao realizar reserva"),
        "error"
      );
      submitBtn.textContent = originalText;
      submitBtn.disabled = false;
    }
  } catch (error) {
    console.error("Erro ao processar reserva:", error);
    showNotification("Erro ao processar reserva: " + error.message, "error");
    submitBtn.textContent = originalText;
    submitBtn.disabled = false;
  }
}
