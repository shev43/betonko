<footer class="footer">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-xl-2 col-md-4 align-self-center text-center text-md-left">
                <a href="{{ route('frontend::pages.index', ['lang'=>\Illuminate\Support\Facades\App::getLocale()]) }}">
                    @include('frontend._modules.logo')
                </a>
            </div>
            <div class="col-xl-4 col-md-8 align-self-center text-center text-md-left">
                <a href="tel:+380967790361" class="footer-contact">
                    <svg>
                        <use xlink:href="#icon-10"></use>
                    </svg>
                    <span>096 779-03-61</span>
                </a>
                <a href="#" data-toggle="modal" data-target="#contact_usModal" class="footer-contact">
                    <svg>
                        <use xlink:href="#icon-11"></use>
                    </svg>
                    <span>Підтримка</span>
                </a>
            </div>
            <div class="col-xl-3 col-md-6 text-center text-md-left">
                <ul class="footer-nav">
                    <li>
                        <a href="{{ route('frontend::catalog.index', ['lang'=>app()->getLocale()]) }}" class="footer-link">Каталог</a>
                    </li>
                    <li>
                        <a href="#" data-toggle="modal" data-target="#contact_usModal" class="footer-link">Підтримка</a>
                    </li>
                </ul>
            </div>
            <div class="col-xl-3 col-md-6 text-center text-md-left">
                <ul class="footer-nav">
                    <li>
                        <a href="{{ route('frontend::policy', ['lang'=>app()->getLocale()]) }}" class="footer-link">Політика конфіденційності</a>
                    </li>
                    <li>
                        <a href="{{ route('frontend::rules', ['lang'=>app()->getLocale()]) }}" class="footer-link">Умови користування</a>
                    </li>
                </ul>
            </div>
        </div>
    </div>
</footer>
