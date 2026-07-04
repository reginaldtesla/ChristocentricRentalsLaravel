<section id="newsletter" class="newsletter-band">
    <div class="container-site">
        <div class="newsletter-card">
            <div class="newsletter-signup">
                <p class="newsletter-eyebrow">{{ config('site.newsletter.eyebrow') }}</p>
                <h2 class="newsletter-heading">{{ config('site.newsletter.heading') }}</h2>
                <p class="newsletter-subtext">{{ config('site.newsletter.subtext') }}</p>

                @if (session('newsletter_success'))
                    <p class="newsletter-flash newsletter-flash--success" role="status">
                        {{ session('newsletter_success') }}
                    </p>
                @endif

                <form class="newsletter-form" action="{{ route('newsletter.subscribe') }}" method="POST">
                    @csrf
                    <label for="newsletter-email" class="sr-only">Email address</label>
                    <input
                        id="newsletter-email"
                        type="email"
                        name="email"
                        value="{{ old('email') }}"
                        placeholder="Your email address"
                        required
                        class="newsletter-input @error('email') newsletter-input--error @enderror"
                    >
                    <button type="submit" class="newsletter-submit">{{ config('site.newsletter.button') }}</button>
                </form>

                @error('email')
                    <p class="newsletter-flash newsletter-flash--error">{{ $message }}</p>
                @enderror

                <p class="newsletter-legal">
                    {{ config('site.newsletter.privacy_note') }}
                    <a href="{{ route('privacy') }}">Privacy Policy</a>.
                </p>
            </div>

            <div class="newsletter-note">
                <div class="newsletter-note-inner">
                    <img
                        src="{{ asset('images/' . config('site.newsletter.founder_avatar')) }}"
                        alt=""
                        class="newsletter-avatar"
                        width="72"
                        height="72"
                    >
                    <blockquote class="newsletter-quote">
                        <p>{{ config('site.newsletter.founder_quote') }}</p>
                    </blockquote>
                    <p class="newsletter-signature">
                        <span class="newsletter-signature-name">{{ config('site.newsletter.founder_name') }}</span>
                        <span class="newsletter-signature-role">{{ config('site.newsletter.founder_role') }}</span>
                    </p>
                </div>
            </div>
        </div>
    </div>
</section>
