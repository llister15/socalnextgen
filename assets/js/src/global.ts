/**
 * File global.ts.
 *
 * Handles global TypeScript for your theme.
 */

// Extend the Window interface properly
declare global {
	interface Window {
		mobileBreakpoint: number;
		isWidthMobile: () => boolean;
		wpRig?: Element | null;
	}
}

// This export makes the file a module and allows declare global to work
export {};

window.mobileBreakpoint = 55;

window.isWidthMobile = (): boolean => {
	const fontSizeStr = getComputedStyle(
		document.documentElement
	).fontSize.slice(0, -2);
	const fontSize = parseFloat(fontSizeStr);
	const emValue = window.innerWidth / fontSize;
	window.wpRig = document.querySelector('.wp-rig');
	return emValue <= window.mobileBreakpoint;
};

const initPageLoader = (): void => {
	const loader = document.querySelector<HTMLElement>('.scng-page-loader');

	if (!loader) {
		return;
	}

	let isReleased = false;
	let removalTimer = 0;

	const releaseLoader = (): void => {
		if (isReleased) {
			return;
		}

		isReleased = true;
		loader.classList.add('is-exiting');
		document.documentElement.classList.add('scng-page-ready');
		removalTimer = window.setTimeout(() => loader.remove(), 360);
	};

	if ('complete' === document.readyState) {
		releaseLoader();
	} else {
		window.addEventListener('load', releaseLoader, { once: true });
	}

	window.setTimeout(releaseLoader, 8000);
	window.addEventListener(
		'pagehide',
		() => window.clearTimeout(removalTimer),
		{ once: true }
	);
};

const initBackToTop = (): void => {
	const button =
		document.querySelector<HTMLButtonElement>('.scng-back-to-top');

	if (!button) {
		return;
	}

	let isTicking = false;

	const updateVisibility = (): void => {
		const isVisible = window.scrollY > 400;

		button.classList.toggle('is-visible', isVisible);
		button.setAttribute('aria-hidden', isVisible ? 'false' : 'true');
		button.tabIndex = isVisible ? 0 : -1;
	};

	const handleScroll = (): void => {
		if (isTicking) {
			return;
		}

		isTicking = true;
		window.requestAnimationFrame(() => {
			updateVisibility();
			isTicking = false;
		});
	};

	button.hidden = false;
	updateVisibility();
	window.addEventListener('scroll', handleScroll, { passive: true });
	button.addEventListener('click', () => {
		const prefersReducedMotion = window.matchMedia(
			'(prefers-reduced-motion: reduce)'
		).matches;

		window.scrollTo({
			top: 0,
			behavior: prefersReducedMotion ? 'auto' : 'smooth',
		});
	});
};

if ('loading' === document.readyState) {
	document.addEventListener('DOMContentLoaded', initPageLoader, {
		once: true,
	});
	document.addEventListener('DOMContentLoaded', initBackToTop, {
		once: true,
	});
} else {
	initPageLoader();
	initBackToTop();
}
