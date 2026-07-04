document.addEventListener('DOMContentLoaded', () => {
    initHeroSlider();
    initDealsSlider();
    initProductScroll();
    initMobileMenu();
    initProductTabs();
    initRentalQuote();
    initAdminHomepageEditor();
    initAdminRentalCountdowns();
});

function initSlider({ root, slideSelector, dotSelector, prevSelector, nextSelector, interval = 5000 }) {
    const slider = document.querySelector(root);
    if (!slider) return;

    const slides = slider.querySelectorAll(slideSelector);
    const dots = slider.querySelectorAll(dotSelector);
    const prev = prevSelector ? slider.querySelector(prevSelector) : null;
    const next = nextSelector ? slider.querySelector(nextSelector) : null;
    let current = 0;
    let timer;

    const show = (index) => {
        current = (index + slides.length) % slides.length;
        slides.forEach((slide, i) => {
            const active = i === current;
            slide.classList.toggle('opacity-100', active);
            slide.classList.toggle('opacity-0', !active);
            slide.classList.toggle('pointer-events-none', !active);
            slide.classList.toggle('absolute', !active && slides.length > 1);
            slide.classList.toggle('inset-0', !active && slides.length > 1);
        });
        dots.forEach((dot, i) => {
            dot.classList.toggle('w-6', i === current);
            dot.classList.toggle('w-1.5', i !== current);
            dot.classList.toggle('bg-primary', i === current);
            dot.classList.toggle('bg-gray-300', i !== current);
        });
    };

    const restart = () => {
        clearInterval(timer);
        timer = setInterval(() => show(current + 1), interval);
    };

    prev?.addEventListener('click', () => { show(current - 1); restart(); });
    next?.addEventListener('click', () => { show(current + 1); restart(); });
    dots.forEach((dot, i) => dot.addEventListener('click', () => { show(i); restart(); }));

    show(0);
    restart();
}

function initHeroSlider() {
    initSlider({
        root: '[data-hero-slider]',
        slideSelector: '[data-hero-slide]',
        dotSelector: '[data-hero-dot]',
        prevSelector: '[data-hero-prev]',
        nextSelector: '[data-hero-next]',
        interval: 5000,
    });
}

function initDealsSlider() {
    initSlider({
        root: '[data-deals-slider]',
        slideSelector: '[data-deals-slide]',
        dotSelector: '[data-deals-dot]',
        prevSelector: '[data-deals-prev]',
        nextSelector: '[data-deals-next]',
        interval: 6000,
    });
}

function initProductScroll() {
    document.querySelectorAll('[data-product-scroll]').forEach((root) => {
        const track = root.querySelector('[data-product-scroll-track]');
        const prev = root.querySelector('[data-product-scroll-prev]');
        const next = root.querySelector('[data-product-scroll-next]');
        if (!track) return;

        const scrollBy = () => Math.max(track.clientWidth * 0.75, 280);

        prev?.addEventListener('click', () => {
            track.scrollBy({ left: -scrollBy(), behavior: 'smooth' });
        });
        next?.addEventListener('click', () => {
            track.scrollBy({ left: scrollBy(), behavior: 'smooth' });
        });
    });
}

function initMobileMenu() {
    const toggle = document.querySelector('[data-mobile-menu-toggle]');
    const panel = document.querySelector('[data-mobile-menu]');
    if (!toggle || !panel) return;
    toggle.addEventListener('click', () => panel.classList.toggle('hidden'));
}

function initProductTabs() {
    document.querySelectorAll('[data-product-tabs]').forEach((root) => {
        const style = root.dataset.tabStyle ?? 'pill';
        const triggers = root.querySelectorAll('[data-tab-trigger]');
        const panels = root.querySelectorAll('[data-tab-panel]');

        const setActive = (trigger) => {
            const key = trigger.dataset.tabTrigger;

            triggers.forEach((t) => {
                const active = t === trigger;

                if (style === 'underline') {
                    t.classList.toggle('tab-trigger--active', active);
                    return;
                }

                t.classList.toggle('border-gray-900', active);
                t.classList.toggle('bg-gray-900', active);
                t.classList.toggle('text-white', active);
                t.classList.toggle('border-gray-200', !active);
                t.classList.toggle('bg-white', !active);
                t.classList.toggle('text-gray-600', !active);
            });

            panels.forEach((panel) => {
                panel.classList.toggle('hidden', panel.dataset.tabPanel !== key);
            });
        };

        triggers.forEach((trigger) => {
            trigger.addEventListener('click', () => setActive(trigger));
        });
    });
}

function initRentalQuote() {
    const form = document.querySelector('[data-rental-form]');
    if (!form) return;

    const start = form.querySelector('[data-rental-start]');
    const end = form.querySelector('[data-rental-end]');
    const qty = form.querySelector('[data-rental-qty]');
    const price = form.querySelector('[data-price-per-day]');
    const daysEl = form.querySelector('[data-rental-days]');
    const totalEl = form.querySelector('[data-rental-total]');
    const availabilityEl = form.querySelector('[data-rental-availability]');
    const submitBtn = form.querySelector('[data-rental-submit]');
    const stockLabel = document.querySelector('[data-rental-stock-label]');
    const token = document.querySelector('meta[name="csrf-token"]')?.content;

    const setAvailabilityUi = (state, message) => {
        if (!availabilityEl) return;

        availabilityEl.textContent = message;
        availabilityEl.classList.remove('hidden', 'is-loading', 'is-available', 'is-limited', 'is-unavailable');
        availabilityEl.classList.add(`is-${state}`);
    };

    const setSubmitState = (available) => {
        if (!submitBtn) return;

        if (available === 0 || available === null) {
            submitBtn.disabled = true;
            submitBtn.textContent = available === 0
                ? 'Not available for these dates'
                : 'Add to cart';
        } else {
            submitBtn.disabled = false;
            submitBtn.textContent = 'Add to cart';
        }
    };

    const updateStockLabel = (available) => {
        if (!stockLabel || typeof available !== 'number') return;

        stockLabel.classList.remove('text-green-700', 'text-amber-700', 'text-red-700');

        if (available === 0) {
            stockLabel.textContent = 'Booked for these dates';
            stockLabel.classList.add('text-red-700');
        } else if (available === 1) {
            stockLabel.textContent = '1 unit left for these dates';
            stockLabel.classList.add('text-amber-700');
        } else {
            stockLabel.textContent = `${available} units available for these dates`;
            stockLabel.classList.add('text-green-700');
        }
    };

    const update = async () => {
        if (!start?.value || !end?.value) return;

        setAvailabilityUi('loading', 'Checking availability for your dates…');
        setSubmitState(null);
        if (submitBtn) submitBtn.disabled = true;

        const response = await fetch('/cart/quote', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': token,
                'Accept': 'application/json',
            },
            body: JSON.stringify({
                product_id: form.dataset.productId || null,
                price_per_day: price?.value,
                rental_start: start.value,
                rental_end: end.value,
                quantity: qty?.value || 1,
            }),
        });

        if (!response.ok) {
            setAvailabilityUi('unavailable', 'Could not check availability. Please try again.');
            setSubmitState(0);
            return;
        }

        const data = await response.json();
        if (daysEl) daysEl.textContent = `${data.days} day(s)`;
        if (totalEl) totalEl.textContent = data.formatted;

        const available = typeof data.available === 'number' ? data.available : null;
        const maxQty = typeof data.max_quantity === 'number' ? data.max_quantity : null;

        if (qty && maxQty !== null) {
            qty.max = Math.max(maxQty, 1);
            qty.disabled = maxQty === 0;
            if (maxQty > 0 && Number(qty.value) > maxQty) {
                qty.value = maxQty;
            }
            if (maxQty === 0) {
                qty.value = 1;
            }
        }

        if (available === 0) {
            setAvailabilityUi(
                'unavailable',
                'Not available for these dates. This item is already booked for all or part of this period. Try different pickup or return dates, or contact us for help.',
            );
            setSubmitState(0);
            updateStockLabel(0);
        } else if (available === 1) {
            setAvailabilityUi('limited', 'Only 1 unit left for these dates.');
            setSubmitState(1);
            updateStockLabel(1);
        } else if (available !== null) {
            setAvailabilityUi('available', `${available} units available for these dates.`);
            setSubmitState(available);
            updateStockLabel(available);
        } else {
            availabilityEl?.classList.add('hidden');
            setSubmitState(1);
        }
    };

    [start, end, qty].forEach((el) => el?.addEventListener('change', update));
    update();
}

function initAdminHomepageEditor() {
    const root = document.querySelector('[data-homepage-editor]');
    if (!root) return;

    root.addEventListener('click', (event) => {
        const urlChip = event.target.closest('[data-url-fill]');
        if (urlChip) {
            event.preventDefault();
            const field = urlChip.closest('[data-url-field]')?.querySelector('input[type="text"]');
            if (field) {
                field.value = urlChip.dataset.urlFill;
                field.focus();
            }
            return;
        }

        const addButton = event.target.closest('[data-editor-add]');
        if (addButton) {
            event.preventDefault();
            addHomepageEditorItem(addButton.closest('.admin-editor-section'));
            return;
        }

        const removeButton = event.target.closest('[data-editor-remove]');
        if (removeButton) {
            event.preventDefault();
            event.stopPropagation();
            removeHomepageEditorItem(removeButton.closest('[data-editor-item]'));
        }
    });

    root.addEventListener('change', (event) => {
        const imageInput = event.target.closest('[data-admin-image-input]');
        if (!imageInput) return;

        const file = imageInput.files?.[0];
        const wrap = imageInput.closest('[data-admin-image-upload]');
        const preview = wrap?.querySelector('[data-admin-image-preview]');
        const previewWrap = wrap?.querySelector('[data-admin-image-preview-wrap]');
        if (!file || !preview || !previewWrap) return;

        const reader = new FileReader();
        reader.onload = (loadEvent) => {
            preview.src = loadEvent.target?.result ?? '';
            previewWrap.hidden = false;

            const item = imageInput.closest('[data-editor-item]');
            const thumb = item?.querySelector('[data-item-thumb]');
            if (thumb) {
                thumb.src = preview.src;
                thumb.hidden = false;
            }
            item?.querySelector('[data-item-thumb-placeholder]')?.remove();
        };
        reader.readAsDataURL(file);
    });

    root.addEventListener('input', (event) => {
        const titleSource = event.target.closest('[data-item-title-source]');
        if (!titleSource) return;

        const preview = titleSource.closest('[data-editor-item]')?.querySelector('[data-item-title-preview]');
        if (preview) {
            preview.textContent = titleSource.value.trim() || 'New item';
        }
    });

    root.querySelectorAll('.admin-editor-nav-link').forEach((link) => {
        link.addEventListener('click', (event) => {
            const target = document.querySelector(link.getAttribute('href') ?? '');
            if (!target) return;
            event.preventDefault();
            target.scrollIntoView({ behavior: 'smooth', block: 'start' });
        });
    });

    root.querySelectorAll('[data-editor-list]').forEach((list) => {
        reindexHomepageEditorList(list);
    });
}

function addHomepageEditorItem(section) {
    const list = section?.querySelector('[data-editor-list]');
    const template = document.getElementById(list?.dataset.editorTemplate ?? '');
    if (!list || !template) return;

    const max = Number(list.dataset.editorMax ?? '12');
    const count = list.querySelectorAll('[data-editor-item]').length;
    if (count >= max) {
        window.alert(`You can add up to ${max} items in this section.`);
        return;
    }

    const html = template.innerHTML.replaceAll('__INDEX__', String(count));
    list.insertAdjacentHTML('beforeend', html);
    reindexHomepageEditorList(list);

    const newItem = list.querySelectorAll('[data-editor-item]')[count];
    newItem?.scrollIntoView({ behavior: 'smooth', block: 'nearest' });
    newItem?.querySelector('input, textarea, select')?.focus();
}

function removeHomepageEditorItem(item) {
    const list = item?.closest('[data-editor-list]');
    if (!list || !item) return;

    if (list.querySelectorAll('[data-editor-item]').length <= 1) {
        window.alert('Each section needs at least one item.');
        return;
    }

    item.remove();
    reindexHomepageEditorList(list);
}

function reindexHomepageEditorList(list) {
    const prefix = list.dataset.editorPrefix;
    const label = list.dataset.editorLabel ?? 'Item';
    const singular = list.dataset.editorSingular ?? 'item';
    const section = list.closest('.admin-editor-section');
    const countEl = section?.querySelector('[data-editor-count]');
    const addButton = section?.querySelector('[data-editor-add]');
    const max = Number(list.dataset.editorMax ?? '12');

    list.querySelectorAll('[data-editor-item]').forEach((item, index) => {
        item.querySelectorAll('[name]').forEach((field) => {
            if (!field.name.startsWith(`${prefix}[`)) return;
            field.name = field.name.replace(new RegExp(`^${prefix}\\[\\d+\\]`), `${prefix}[${index}]`);
        });

        item.querySelectorAll('[id]').forEach((field) => {
            if (field.id.includes('upload-')) {
                field.id = `upload-${prefix}-${index}-${field.type}`;
            }
        });

        const titleLabel = item.querySelector('[data-item-title-label]');
        if (titleLabel) titleLabel.textContent = `${label} ${index + 1}`;

        item.querySelector('[data-editor-remove]').disabled = false;
    });

    const count = list.querySelectorAll('[data-editor-item]').length;
    if (countEl) {
        countEl.textContent = `${count} ${count === 1 ? singular : `${singular}s`}`;
    }

    if (addButton) {
        addButton.disabled = count >= max;
        addButton.classList.toggle('opacity-50', count >= max);
    }

    if (count <= 1) {
        list.querySelector('[data-editor-remove]').disabled = true;
    }
}

function initAdminRentalCountdowns() {
    const cards = document.querySelectorAll('[data-rental-countdown]');
    if (!cards.length) return;

    const dueSoonSeconds = (Number(cards[0]?.dataset.dueSoonHours || 24)) * 3600;

    const formatDuration = (seconds) => {
        seconds = Math.abs(seconds);

        if (seconds < 60) return `${seconds}s`;
        if (seconds < 3600) return `${Math.floor(seconds / 60)}m`;
        if (seconds < 86400) {
            const hours = Math.floor(seconds / 3600);
            const minutes = Math.floor((seconds % 3600) / 60);
            return minutes > 0 ? `${hours}h ${minutes}m` : `${hours}h`;
        }

        const days = Math.floor(seconds / 86400);
        const hours = Math.floor((seconds % 86400) / 3600);
        return hours > 0 ? `${days}d ${hours}h` : `${days}d`;
    };

    const tick = () => {
        cards.forEach((card) => {
            const dueAt = card.dataset.dueAt;
            const display = card.querySelector('[data-countdown-display]');
            if (!dueAt || !display) return;

            const seconds = Math.floor((new Date(dueAt).getTime() - Date.now()) / 1000);
            display.textContent = seconds >= 0
                ? `${formatDuration(seconds)} left`
                : `${formatDuration(seconds)} overdue`;

            card.classList.remove('is-active', 'is-due-soon', 'is-overdue');
            if (seconds < 0) {
                card.classList.add('is-overdue');
            } else if (seconds <= dueSoonSeconds) {
                card.classList.add('is-due-soon');
            } else {
                card.classList.add('is-active');
            }
        });
    };

    tick();
    setInterval(tick, 1000);
}
