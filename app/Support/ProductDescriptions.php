<?php

namespace App\Support;

class ProductDescriptions
{
    /** @return array<string, array{description: string, excerpt: string}> */
    public static function all(): array
    {
        return array_replace(
            self::cameras(),
            self::lenses(),
            self::lighting(),
            self::audio(),
            self::gimbalsAndDrones(),
            self::accessories(),
        );
    }

    /** @return array<string, array{description: string, excerpt: string}> */
    private static function cameras(): array
    {
        $canonR5 = implode("\n\n", [
            'The Canon EOS R5 is built for productions that need premium stills and cinema-ready video from one dependable body. Its 45MP full-frame sensor gives your team freedom to crop, reframe, and deliver sharp images for web, print, and campaign work without sacrificing detail. On fast-paced shoots in Accra, Kumasi, or Cape Coast, the responsive autofocus and high burst performance help you stay with moving subjects while keeping setup time low.',
            'For video teams, the R5 records high-quality 4K and 8K options, includes Canon Log support, and offers in-body stabilization that pairs well with handheld gimbals and monopods. Dual card slots and weather-sealed construction add confidence for weddings, conferences, and ministry events that cannot be repeated. It is a practical choice when you want flagship image quality in a travel-friendly package for rentals across Ghana.',
        ]);

        $canonR6ii = implode("\n\n", [
            'The Canon EOS R6 Mark II delivers excellent low-light performance, accurate color, and fast autofocus in a body that is easy to carry through full-day assignments. Its full-frame sensor and strong dynamic range are well suited for event coverage, interviews, worship services, and branded storytelling where reliable skin tones matter. The camera feels responsive from power-on to playback, which helps crews move quickly between indoor and outdoor locations.',
            'Video users benefit from oversampled 4K capture, dependable subject tracking, and in-body image stabilization that reduces handheld shake without heavy rigs. This body is a strong rental option for creators who need modern hybrid performance but want a simpler file workflow than ultra-high-resolution cinema setups. It is a balanced upgrade for teams shooting social campaigns, documentaries, and corporate content in Ghana.',
        ]);

        $canonR = implode("\n\n", [
            'The Canon EOS R introduced Canon\'s full-frame mirrorless system with a sensor and color profile that still performs beautifully for portrait, church, and small business productions. Its 30MP resolution gives enough room for cropping while keeping file sizes manageable for quick editing and delivery. The electronic viewfinder and articulating screen are helpful for run-and-gun operators who work in changing light.',
            'Paired with an EF adapter, the EOS R becomes a flexible bridge for teams with existing Canon EF lenses. You can keep familiar glass while enjoying mirrorless advantages such as precise eye autofocus and silent operation for sensitive environments. For clients in Ghana who need full-frame quality at a practical rental cost, this setup remains a dependable value choice.',
        ]);

        $canon5diii = implode("\n\n", [
            'The Canon 5D Mark III is a proven full-frame DSLR trusted for wedding coverage, portrait sessions, and documentary work where reliability matters more than trends. Its 22.3MP sensor delivers rich files with natural skin tones and a pleasing tonal roll-off that many photographers still prefer. The body handles confidently, and the optical viewfinder provides a familiar shooting experience in bright sunlight.',
            'This camera is especially practical for teams that need robust battery life and compatibility with classic Canon EF lenses. Dual card slots add backup security for once-in-a-lifetime events, and the durable construction stands up to demanding field use. For ministries, schools, and businesses in Ghana, the 5D Mark III remains a dependable rental workhorse.',
        ]);

        $canon5div = implode("\n\n", [
            'The Canon 5D Mark IV refines the 5D legacy with a 30.4MP full-frame sensor, faster processing, and excellent color depth for professional still photography. It performs confidently in mixed lighting and delivers clean files for portraits, corporate headshots, and event documentation. Autofocus improvements make it easier to maintain sharp results when subjects move unpredictably.',
            'For hybrid teams, the camera adds solid 4K capability and dependable weather-sealed DSLR ergonomics that many operators prefer for long shooting days. Built-in GPS and wireless options support streamlined workflows for distributed productions. It is a strong rental option when you need premium Canon image quality and rugged reliability for projects across Ghana.',
        ]);

        $canon6dii = implode("\n\n", [
            'The Canon 6D Mark II offers accessible full-frame quality in a lightweight DSLR design that is easy to learn and efficient to deploy. Its 26.2MP sensor produces clean, vibrant files suitable for portraits, church events, and social media content with professional polish. The vari-angle touchscreen is especially useful for low-angle and overhead compositions in tight locations.',
            'Dual Pixel autofocus in live view provides smooth focus transitions for simple interview and B-roll capture. With strong battery endurance and straightforward controls, the 6D Mark II helps smaller crews stay productive without heavy technical overhead. It is an excellent rental camera for creators in Ghana moving from crop-sensor bodies to full-frame results.',
        ]);

        $canon6d = implode("\n\n", [
            'The Canon 6D remains a dependable full-frame DSLR for photographers who value clean low-light performance and classic Canon color science. Its 20.2MP sensor is well matched to portrait sessions, engagement shoots, and indoor events where natural rendering is more important than extreme resolution. The camera body is compact for a full-frame DSLR, making it comfortable for long handheld sessions.',
            'Integrated Wi-Fi and GPS simplify file previews and basic location tracking, while the EF lens ecosystem keeps setup options broad and affordable. For budget-conscious productions that still require full-frame depth and image quality, the 6D is a practical rental choice. It continues to serve ministries and small businesses throughout Ghana with consistent results.',
        ]);

        $canon80d = implode("\n\n", [
            'The Canon 80D is a capable APS-C DSLR designed for creators who need strong autofocus, good battery life, and straightforward controls. Its 24.2MP sensor delivers detailed stills for school events, youth programs, and online marketing with manageable file sizes. The camera\'s ergonomics make it comfortable for newer operators and volunteers.',
            'For video, Dual Pixel AF and a fully articulating touchscreen help solo shooters frame confidently and keep interviews in focus. The 80D pairs well with affordable EF and EF-S lenses, making it easy to build complete kits for multi-camera coverage. It is a dependable rental option for practical, budget-aware productions in Ghana.',
        ]);

        $canonXa11 = implode("\n\n", [
            'The Canon XA11 is a compact professional camcorder built for dependable event and documentary coverage. Its integrated zoom lens, XLR audio inputs, and ergonomic top handle make it ideal for worship services, conferences, and field interviews where speed and audio quality are critical. You can move from wide establishing shots to tighter framing without changing lenses.',
            'This camcorder is designed for long recording sessions with straightforward controls that reduce setup time for volunteer teams and solo operators. Optical stabilization and reliable autofocus support clean handheld footage in crowded venues. For churches, schools, and media teams in Ghana, the XA11 is a practical rental solution for turnkey video capture.',
        ]);

        $sonyA7iv = implode("\n\n", [
            'The Sony A7 IV combines a 33MP full-frame sensor with advanced autofocus, making it a strong hybrid camera for both stills and video assignments. It delivers crisp detail for commercial photography while maintaining excellent low-light performance for indoor events and evening shoots. Real-time subject tracking helps operators stay sharp on faces and eyes even in busy scenes.',
            'Video teams benefit from high-quality 4K recording, robust color options including S-Log3, and modern connectivity for fast turnaround workflows. The body is compact enough for travel yet durable for repeated rental use. It is a top-tier choice for Ghanaian creators who need one camera system that can handle campaigns, weddings, and documentary storytelling.',
        ]);

        $sonyA7iii = implode("\n\n", [
            'The Sony A7 III is widely trusted for balanced full-frame performance, strong battery life, and dependable autofocus. Its 24.2MP sensor produces clean, flexible files for portraits, events, and content creation where speed and consistency matter. The camera is easy to rig for both stills and video, making it ideal for mixed assignments.',
            'With excellent low-light capability and dual card slots, the A7 III remains a practical professional rental body for mission-critical shoots. It integrates smoothly with Sony E-mount lenses and common stabilizers used by Ghana-based production teams. This is a reliable option when you want proven results with minimal setup friction.',
        ]);

        $sonyFx3 = implode("\n\n", [
            'The Sony FX3 is a compact cinema camera from Sony\'s Cinema Line, engineered for serious video production in a small form factor. Its full-frame sensor delivers cinematic depth, strong dynamic range, and excellent low-light performance for documentary, worship, and branded film work. The included mounting points and modular design make it easy to build lightweight rigs for gimbals, handheld, or vehicle setups.',
            'Professional codecs, advanced autofocus, dual base ISO behavior, and full-size HDMI support help crews capture high-quality footage with confidence. Active cooling enables extended takes for interviews and live event capture in warm environments. For production houses and creators in Ghana, the FX3 is a premium rental choice when video quality and reliability are non-negotiable.',
        ]);

        $nikonD750 = implode("\n\n", [
            'The Nikon D750 is a respected full-frame DSLR known for pleasing color, strong dynamic range, and reliable low-light performance. Its 24.3MP sensor delivers detailed stills for weddings, portraits, and corporate events with a natural, flattering look. The lightweight full-frame body is comfortable for long shooting days and mobile assignments.',
            'Fast autofocus, dual card slots, and sturdy handling make it dependable for important moments where you need consistency over long sessions. The D750 pairs with Nikon F-mount lenses that remain popular for both photography and basic video capture. It is a practical rental option for Ghanaian shooters who want proven Nikon full-frame performance.',
        ]);

        $blackmagic6kPro = implode("\n\n", [
            'The Blackmagic Pocket Cinema Camera 6K Pro is built for filmmakers who prioritize color depth, post-production flexibility, and cinematic control. Its Super 35 sensor and EF mount support a wide range of lenses, while internal Blackmagic RAW and ProRes recording preserve detail for grading and finishing. The bright tilting HDR screen and integrated ND filters speed up outdoor workflows under Ghana\'s strong daylight.',
            'Dual mini-XLR audio, timecode options, and high-bitrate codecs make this camera well suited for narrative projects, music videos, and commercial production. It rewards crews that want deliberate exposure and color workflows rather than baked-in looks. As a rental, it is ideal for teams delivering premium cinematic visuals on serious productions.',
        ]);

        $panasonicUx90 = implode("\n\n", [
            'The Panasonic UX90 is a professional handheld camcorder designed for efficient ENG, event, and documentary coverage. Its integrated zoom range and practical controls allow operators to respond quickly to changing scenes without lens swaps. The camera supports broadcast-style operation with stable handling for long sessions.',
            'With dual SD recording, professional audio inputs, and dependable autofocus behavior, the UX90 is a strong fit for conferences, church broadcasts, and institutional video work. It simplifies multi-hour recording where reliability and clear sound are essential. For teams in Ghana needing a ready-to-shoot camcorder package, the UX90 is a smart rental choice.',
        ]);

        $sonyPxwX70 = implode("\n\n", [
            'The Sony PXW-X70 is a compact professional camcorder that blends portability with features expected in broadcast and corporate environments. Its 1-inch class sensor helps produce cleaner images and better background separation than smaller-sensor camcorders. The built-in zoom lens and ergonomics support fast operation for interviews and event coverage.',
            'XLR audio support, ND filters, and long recording reliability make it useful for church media teams, field reporters, and documentary crews. It is easy to deploy for one-person productions while still delivering professional controls. For Ghana-based clients needing dependable run-and-gun video capture, the PXW-X70 remains a practical rental tool.',
        ]);

        $sonyPxwZ90 = implode("\n\n", [
            'The Sony PXW-Z90 is a compact 4K professional camcorder designed for high-efficiency production and quick turnaround delivery. Its fast hybrid autofocus and 1-inch class sensor help maintain sharp, clean images in dynamic environments. The integrated zoom and optical stabilization make it ideal for handheld event and documentary work.',
            'Professional audio inputs, HDR workflows, and dependable long-form recording support broadcast, corporate, and ministry productions. This camera is especially valuable for teams that need modern 4K acquisition without complex cinema rigging. It is a strong rental option for Ghanaian productions that prioritize speed, reliability, and professional output.',
        ]);

        return [
            'canon-r5-body-only' => [
                'description' => $canonR5,
                'excerpt' => 'Canon R5 body with flagship full-frame performance for high-detail photo and 4K/8K-ready video rentals.',
            ],
            'cannon-r5-body-only' => [
                'description' => $canonR5,
                'excerpt' => 'Canon R5 body with flagship full-frame performance for high-detail photo and 4K/8K-ready video rentals.',
            ],
            'canon-r6-mark-ii-body-only' => [
                'description' => $canonR6ii,
                'excerpt' => 'Canon R6 Mark II body built for fast hybrid shooting, strong low-light results, and smooth autofocus.',
            ],
            'canon-r6-with-ef-adaptor' => [
                'description' => $canonR6ii,
                'excerpt' => 'Canon R6 setup with EF adapter for modern mirrorless speed while using familiar EF lenses.',
            ],
            'canon-r-with-adaptor' => [
                'description' => $canonR,
                'excerpt' => 'Canon EOS R with EF adapter offering full-frame quality and broad EF lens compatibility.',
            ],
            'canon-5d-mark-iii' => [
                'description' => $canon5diii,
                'excerpt' => 'Canon 5D Mark III full-frame DSLR trusted for weddings, portraits, and dependable event coverage.',
            ],
            'experience-the-power-of-the-canon-5d-mark-iii' => [
                'description' => $canon5diii,
                'excerpt' => 'Canon 5D Mark III full-frame DSLR trusted for weddings, portraits, and dependable event coverage.',
            ],
            'canon-5d-mark-iv' => [
                'description' => $canon5div,
                'excerpt' => 'Canon 5D Mark IV adds high-resolution full-frame detail and robust pro DSLR reliability.',
            ],
            'canon-6d-mark-ii' => [
                'description' => $canon6dii,
                'excerpt' => 'Canon 6D Mark II offers approachable full-frame image quality for photo and light video work.',
            ],
            'canon-6d' => [
                'description' => $canon6d,
                'excerpt' => 'Canon 6D full-frame DSLR delivers clean low-light images in a practical, budget-friendly body.',
            ],
            'canon-80d' => [
                'description' => $canon80d,
                'excerpt' => 'Canon 80D is a reliable APS-C DSLR for events, interviews, and everyday content production.',
            ],
            'canon-xa11' => [
                'description' => $canonXa11,
                'excerpt' => 'Canon XA11 camcorder with XLR audio and integrated zoom for turnkey professional event capture.',
            ],
            'sony-a7-iv' => [
                'description' => $sonyA7iv,
                'excerpt' => 'Sony A7 IV delivers modern full-frame hybrid performance for premium photo and video jobs.',
            ],
            'sony-a7-mark-iii' => [
                'description' => $sonyA7iii,
                'excerpt' => 'Sony A7 III remains a trusted full-frame workhorse with strong low-light and dependable autofocus.',
            ],
            'sony-fx3' => [
                'description' => $sonyFx3,
                'excerpt' => 'Sony FX3 cinema body offers full-frame cinematic video quality in a compact production-ready form.',
            ],
            'nikon-d750-dslr' => [
                'description' => $nikonD750,
                'excerpt' => 'Nikon D750 full-frame DSLR provides proven image quality and reliability for professional shoots.',
            ],
            '16605' => [
                'description' => $blackmagic6kPro,
                'excerpt' => 'Blackmagic 6K Pro delivers cinema-focused image control with internal RAW and built-in ND filters.',
            ],
            'panasonic-ux90' => [
                'description' => $panasonicUx90,
                'excerpt' => 'Panasonic UX90 camcorder is built for efficient long-form event, ENG, and documentary coverage.',
            ],
            'sony-pxw-x70' => [
                'description' => $sonyPxwX70,
                'excerpt' => 'Sony PXW-X70 packs pro camcorder controls and audio tools into a compact run-and-gun body.',
            ],
            'sony-pxw-z90' => [
                'description' => $sonyPxwZ90,
                'excerpt' => 'Sony PXW-Z90 is a compact 4K pro camcorder for fast, reliable broadcast-style production.',
            ],
        ];
    }

    /** @return array<string, array{description: string, excerpt: string}> */
    private static function lenses(): array
    {
        $canon16_35ii = implode("\n\n", [
            'The Canon EF 16-35mm f/2.8L II is a classic ultra-wide zoom that gives photographers and filmmakers broad framing flexibility in tight spaces. It is well suited for interiors, architecture, group portraits, and event establishing shots where you need to capture more of the scene. The constant f/2.8 aperture helps maintain exposure consistency while zooming during live workflows.',
            'As a rental lens, it is a practical choice for crews covering weddings, church services, and real estate visuals across Ghana. Its L-series build quality stands up to frequent use and travel between locations. Pair it with full-frame Canon bodies when you need dynamic wide perspectives with dependable performance.',
        ]);

        $canon16_35iii = implode("\n\n", [
            'The Canon EF 16-35mm f/2.8L III builds on Canon\'s wide-angle legacy with improved edge-to-edge sharpness and contrast. It is a premium option for high-resolution sensors when your client needs crisp architectural lines, dramatic environmental portraits, or polished event coverage. The fast f/2.8 aperture supports low-light shooting and creative separation at close distances.',
            'For rental productions in Ghana, this lens is especially valuable when shooting interiors, large gatherings, or cinematic gimbal movement through confined spaces. Weather-resistant construction and dependable autofocus support demanding schedules. It is a top choice for teams that want flagship Canon wide-angle quality.',
        ]);

        $canon70_200iii = implode("\n\n", [
            'The Canon EF 70-200mm f/2.8L IS III is a professional telephoto zoom trusted for weddings, sports, conferences, and portrait sessions. Its focal range allows operators to move from medium framing to tight close-ups without changing position, which is ideal during live events. The constant f/2.8 aperture and image stabilization help maintain sharp results in variable lighting.',
            'This lens is a rental staple for Ghanaian creators who need premium flexibility and dependable autofocus on Canon EF bodies. It handles beautifully for both stills and video, especially when paired with monopods or stabilized rigs. If your shoot demands reach, speed, and consistency, this lens is an excellent fit.',
        ]);

        $canon70_200ii = implode("\n\n", [
            'The Canon EF 70-200mm f/2.8L IS II remains one of the most respected telephoto zooms ever made in the EF lineup. It offers strong sharpness, pleasing compression, and fast autofocus for portraits, ceremonies, and stage events. The lens delivers professional results even under challenging indoor lighting.',
            'For rental use, it continues to be a dependable performer with proven optical quality and durable construction. It is ideal for photographers and videographers who need distance coverage without sacrificing image character. Across Ghana\'s event and corporate production landscape, this lens remains a trusted workhorse.',
        ]);

        $canon24_105ii = implode("\n\n", [
            'The Canon EF 24-105mm f/4L IS II is a versatile all-purpose zoom that covers wide, standard, and short telephoto framing in one lens. It is excellent for documentary shooting, corporate videos, and travel assignments where lens changes slow you down. Image stabilization helps deliver cleaner handheld footage and sharper stills in moderate light.',
            'This lens is ideal for rental clients who want flexibility and dependable L-series build quality without carrying multiple primes. From interviews to event highlights, it handles varied scenes with efficient workflow. It is a practical choice for creators moving quickly between locations in Ghana.',
        ]);

        $canon24_70ii = implode("\n\n", [
            'The Canon EF 24-70mm f/2.8L II is a flagship standard zoom known for excellent sharpness and consistent performance across its focal range. It is a go-to lens for weddings, commercial shoots, and editorial work because it adapts quickly to changing compositions. The f/2.8 aperture supports low-light shooting and natural subject separation.',
            'As a rental lens, it is perfect for teams that need one premium optic to handle most day-to-day assignments. Autofocus speed and optical quality make it dependable for both photo and video production. For professional projects across Ghana, this lens remains a trusted first choice.',
        ]);

        $canon50_14 = implode("\n\n", [
            'The Canon EF 50mm f/1.4 is a fast standard prime that delivers flattering perspective and bright low-light performance. It is popular for portraits, interviews, and storytelling shots where you want natural framing with gentle background blur. The compact design keeps camera rigs light and easy to manage.',
            'For rental clients, this lens offers an affordable way to achieve a cinematic look without heavy equipment. It performs well for both still photography and simple video setups. In Ghana\'s indoor venues and evening events, the wide aperture is especially useful.',
        ]);

        $canon85_18 = implode("\n\n", [
            'The Canon EF 85mm f/1.8 is a classic portrait prime with strong subject isolation and pleasing compression. It creates a polished look for headshots, wedding portraits, and interview framing where background separation matters. Autofocus is quick, making it practical for both posed and candid moments.',
            'This lens is a smart rental option for creators who want professional portrait results with a lightweight kit. It also works well in low-light church and event settings common across Ghana. If you need clean, flattering close-ups, this prime consistently delivers.',
        ]);

        $canon85_12ii = implode("\n\n", [
            'The Canon EF 85mm f/1.2L II is an iconic portrait lens known for its luxurious rendering and exceptionally shallow depth of field. It produces striking subject separation and smooth background blur that can elevate bridal, fashion, and premium brand portraits. The optical character gives images a distinct high-end feel.',
            'As a rental, this lens is ideal when clients want signature portrait aesthetics rather than purely clinical sharpness. It rewards deliberate shooting and careful focus technique, especially at wide apertures. For premium portrait sessions in Ghana, it remains a standout creative tool.',
        ]);

        $canon50_18 = implode("\n\n", [
            'The Canon EF 50mm f/1.8 is a lightweight, affordable prime that gives sharp images and bright aperture performance in a compact package. It is ideal for entry-level portrait work, event details, and interview framing where natural perspective is preferred. The lens is easy to carry and fast to deploy.',
            'For rentals, it is a practical choice when you need dependable image quality without increasing budget pressure. It works well on both full-frame and APS-C Canon bodies with predictable results. This lens is especially useful for small teams and content creators in Ghana.',
        ]);

        $canon85_14 = implode("\n\n", [
            'The Canon EF 85mm f/1.4L IS combines premium portrait optics with image stabilization, making it highly adaptable for both still and video work. It produces elegant background blur and crisp subject detail while helping reduce handheld shake in low light. This balance is valuable for weddings, interviews, and branded portrait sessions.',
            'As a rental lens, it suits creators who want a refined portrait look with modern usability. The stabilized design supports cleaner handheld footage compared with many traditional portrait primes. It is an excellent option for Ghanaian shoots where mobility and quality must go together.',
        ]);

        $canonRf50_14 = implode("\n\n", [
            'The Canon RF 50mm f/1.4 offers a bright standard focal length for RF-mount mirrorless systems, delivering natural perspective and strong low-light capability. It is useful for portrait sessions, product features, and cinematic interview framing where a flexible prime is needed. The lens supports modern autofocus behavior on Canon\'s latest mirrorless bodies.',
            'For rental workflows, this focal length is easy to use and adapts to many production styles from social content to documentary scenes. It keeps rigs compact while still producing a professional depth-of-field look. It is a practical RF option for creators shooting across Ghana.',
        ]);

        $canonRf70_200 = implode("\n\n", [
            'The Canon RF 70-200mm f/2.8 brings professional telephoto performance to Canon\'s mirrorless ecosystem in a more travel-friendly form. It delivers strong sharpness, fast autofocus, and flattering compression for portraits, events, and stage coverage. The constant f/2.8 aperture supports consistent exposure and subject isolation across the zoom range.',
            'This lens is a premium rental option for teams using Canon RF bodies who need reach without sacrificing speed. Optical stabilization improves handheld reliability for both stills and video capture. It is well suited for high-pressure productions and live events throughout Ghana.',
        ]);

        $canon100Macro = implode("\n\n", [
            'The Canon EF 100mm f/2.8L Macro IS is a specialist lens for close-up detail with true macro capability and excellent sharpness. It is perfect for product photography, wedding ring shots, texture captures, and nature details that require precise rendering. The focal length also doubles as a strong portrait option with pleasing compression.',
            'Hybrid image stabilization helps when shooting handheld close-ups, where small movements are amplified. As a rental, this lens adds creative range for teams producing commercial and documentary content. It is ideal for Ghanaian creators who need both macro precision and portrait versatility in one optic.',
        ]);

        $nikon24_70 = implode("\n\n", [
            'The Nikon 24-70mm f/2.8 is a professional standard zoom built for demanding assignments and daily reliability. It covers essential focal lengths for portraits, events, and documentary work while maintaining a bright constant aperture. The lens delivers strong optical performance and predictable results across varied scenes.',
            'For rental clients using Nikon systems, this is often the first lens to request because it can handle most production needs in one package. It performs well in both photo and video workflows where quick adaptation is required. From conferences in Accra to weddings upcountry, it is a dependable all-round choice.',
        ]);

        $nikon50_18 = implode("\n\n", [
            'The Nikon 50mm f/1.8 is a compact prime that provides natural perspective, sharp imaging, and useful low-light capability. It is well suited for portrait work, interview setups, and day-to-day storytelling where a simple, reliable lens is preferred. The lightweight form factor keeps handheld shooting comfortable.',
            'As a rental option, it gives Nikon shooters an affordable path to shallow depth of field and clean subject focus. It is straightforward for beginners yet dependable for professionals needing a small backup prime. This makes it a valuable lens for flexible production work in Ghana.',
        ]);

        $nikon70_200 = implode("\n\n", [
            'The Nikon 70-200mm f/2.8 is a pro telephoto zoom designed for fast action, portrait compression, and event coverage at distance. It offers strong optical clarity and consistent aperture performance across the range, which is essential for live productions. The focal flexibility helps shooters react quickly without moving through crowded venues.',
            'For rental use, this lens is a go-to for weddings, sports, and stage programs where close framing from afar is critical. Its build quality and autofocus reliability support high-pressure jobs. Nikon users across Ghana rely on this lens for confident telephoto results.',
        ]);

        $sigma150_600 = implode("\n\n", [
            'The Sigma 150-600mm is designed for extreme reach, making it ideal for wildlife, sports, and long-distance outdoor coverage. It allows creators to capture distant subjects with impactful framing that standard telephoto lenses cannot achieve. The zoom range offers flexibility when subject distance changes rapidly.',
            'As a rental lens, it is particularly useful for specialty assignments where maximum focal length is the priority. Pair it with stable support for best results during long sessions. For nature and field production in Ghana, this lens opens perspectives that are otherwise difficult to capture.',
        ]);

        $sigma24_70 = implode("\n\n", [
            'The Sigma 24-70mm f/2.8 is a high-value professional standard zoom offering sharp imagery and broad everyday usability. It covers core focal lengths for portraits, events, interviews, and commercial content while maintaining a bright constant aperture. The lens is favored by creators who want premium performance with efficient budget control.',
            'For rentals, it is a dependable centerpiece lens for both still and video workflows. Build quality and optical consistency make it suitable for demanding schedules and varied locations. It is an excellent option for production teams working across Ghana.',
        ]);

        $sigma35_14 = implode("\n\n", [
            'The Sigma 35mm f/1.4 is a fast wide-normal prime celebrated for its cinematic rendering and low-light strength. It is great for environmental portraits, documentary storytelling, and interview setups that need context around the subject. The bright aperture allows elegant separation while keeping more scene detail than tighter portrait lenses.',
            'As a rental lens, it is ideal for creators who want a premium storytelling focal length with strong artistic character. It performs beautifully on gimbals and handheld rigs for immersive motion shots. This lens is a favorite for creative productions in Ghana.',
        ]);

        $sigma50_14 = implode("\n\n", [
            'The Sigma 50mm f/1.4 delivers a rich, high-contrast look with strong center sharpness and a polished depth-of-field aesthetic. It is well suited for portraits, branded content, and interview framing where image character matters. The standard focal length keeps compositions natural and versatile.',
            'For rentals, this lens offers premium prime quality that elevates both photo and video output. It is an excellent choice when you want cleaner low-light performance and a more cinematic style than kit zooms provide. Ghanaian creators often select it for high-impact visual storytelling.',
        ]);

        $sigma70_200 = implode("\n\n", [
            'The Sigma 70-200mm f/2.8 is a professional telephoto zoom built for events, portraits, and live coverage where distance and speed are critical. It offers constant-aperture performance for consistent exposure and reliable subject isolation across the zoom range. The lens provides the flexibility needed for dynamic production environments.',
            'As a rental choice, it is ideal for teams that need strong telephoto performance with excellent value. It integrates well into multi-camera setups for weddings, worship programs, and conference sessions. This lens is a practical workhorse for demanding projects in Ghana.',
        ]);

        $sigma85_14 = implode("\n\n", [
            'The Sigma 85mm f/1.4 is a premium portrait prime designed to produce striking subject separation and flattering facial compression. It excels in bridal sessions, editorial portraits, and cinematic close-ups where you want a refined background blur. Optical sharpness and rendering quality make it a favorite for high-end portraiture.',
            'For rental clients, this lens provides a strong creative upgrade when portrait quality is central to the brief. It rewards intentional composition and controlled focus for standout results. Across Ghana, it is a trusted choice for premium people-focused imagery.',
        ]);

        $sigmaSony14_24 = implode("\n\n", [
            'The Sigma 14-24mm for Sony systems is an ultra-wide zoom tailored for architecture, interiors, and dramatic landscape or event establishing shots. It captures expansive scenes with strong sharpness and minimal distortion for its class. The fast aperture supports low-light work and creative environmental framing.',
            'As a rental lens for Sony E-mount users, it is ideal when you need to show scale and atmosphere in a single frame. It pairs well with gimbal movement and real-estate production workflows. This is a powerful option for wide visual storytelling in Ghana.',
        ]);

        $sigmaSony85 = implode("\n\n", [
            'The Sigma Sony 85mm lens brings premium portrait rendering to Sony E-mount shooters who want strong compression and smooth bokeh. It is highly effective for headshots, bridal sessions, and interview close-ups with a polished cinematic feel. The focal length naturally flatters facial features while isolating subjects from busy backgrounds.',
            'For rentals, it is a dependable creative lens when portrait quality is the priority. It complements Sony full-frame bodies for both still and video assignments. This lens is well suited to professional portrait and event work across Ghana.',
        ]);

        $sonyGm50_14 = implode("\n\n", [
            'The Sony 50mm f/1.4 G Master delivers flagship prime performance with excellent sharpness, responsive autofocus, and beautiful background rendering. It is a versatile choice for portraits, product visuals, and cinematic interview work where natural perspective is desired. The lens balances premium optical quality with practical size for modern hybrid workflows.',
            'As a rental option, it is ideal for Sony users seeking a top-tier standard prime for both photo and video. The bright aperture helps in low-light indoor venues and evening sessions. It is a strong creative tool for commercial and event production in Ghana.',
        ]);

        $sonyGm70_200 = implode("\n\n", [
            'The Sony G Master 70-200mm f/2.8 is a flagship telephoto zoom built for professional coverage at distance. It combines excellent sharpness, fast autofocus, and premium build quality for sports, weddings, and corporate events. The focal range gives shooters freedom to capture candid close-ups without disrupting live moments.',
            'For rental teams on Sony E-mount, this lens is a top choice for mission-critical assignments where reliability matters. The constant f/2.8 aperture supports consistent exposure and clean subject isolation. It is ideal for high-level productions across Ghana.',
        ]);

        $tamron70_200 = implode("\n\n", [
            'The Tamron 70-200mm f/2.8 offers professional telephoto versatility for creators who need strong performance with efficient value. It handles portraits, events, and stage coverage with the compression and reach expected from a fast telephoto zoom. The constant aperture helps maintain exposure consistency while reframing.',
            'As a rental lens, it is a practical option for teams balancing quality, flexibility, and budget. It performs well in common event environments such as weddings, church programs, and conferences. This makes it a dependable telephoto solution for productions in Ghana.',
        ]);

        $yongnuo50_18 = implode("\n\n", [
            'The Yongnuo 50mm f/1.8 AF is a budget-friendly standard prime that offers bright aperture performance and autofocus convenience. It is useful for portraits, basic interview setups, and low-light scenes where kit lenses struggle. The familiar 50mm perspective keeps framing natural and easy to compose.',
            'For rentals, this lens is ideal for entry-level creators who want to experiment with shallow depth of field at minimal cost. It is lightweight, straightforward, and practical for simple content workflows. In Ghana\'s growing creator market, it is a smart starter prime option.',
        ]);

        return [
            'canon-16-35mm-f-2-8-ii-lens' => [
                'description' => $canon16_35ii,
                'excerpt' => 'Canon 16-35mm f/2.8L II is a dependable ultra-wide zoom for interiors, events, and dramatic scenes.',
            ],
            'canon-16-35mm-f-2-8-iii-lens' => [
                'description' => $canon16_35iii,
                'excerpt' => 'Canon 16-35mm f/2.8L III delivers premium ultra-wide sharpness for high-end photo and video work.',
            ],
            'canon-70-200mm-f-2-8-iii' => [
                'description' => $canon70_200iii,
                'excerpt' => 'Canon 70-200mm f/2.8L IS III is a pro telephoto staple for weddings, portraits, and events.',
            ],
            'canon-70-200mm-f-2-8-iii-lens' => [
                'description' => $canon70_200iii,
                'excerpt' => 'Canon 70-200mm f/2.8L IS III is a pro telephoto staple for weddings, portraits, and events.',
            ],
            'canon-70-200mm-f-2-8-ii' => [
                'description' => $canon70_200ii,
                'excerpt' => 'Canon 70-200mm f/2.8L IS II offers proven telephoto quality for fast-paced professional shoots.',
            ],
            'canon-24-105mm-f-4-0-ii' => [
                'description' => $canon24_105ii,
                'excerpt' => 'Canon 24-105mm f/4L II is a versatile all-in-one zoom for run-and-gun production days.',
            ],
            'canon-24-70mm-f-2-8-ii' => [
                'description' => $canon24_70ii,
                'excerpt' => 'Canon 24-70mm f/2.8L II is a flagship standard zoom for premium event and commercial work.',
            ],
            'canon-50mm-1-4' => [
                'description' => $canon50_14,
                'excerpt' => 'Canon 50mm f/1.4 prime gives bright low-light performance and natural cinematic framing.',
            ],
            'canon-85mm-1-8' => [
                'description' => $canon85_18,
                'excerpt' => 'Canon 85mm f/1.8 is a classic portrait prime with strong subject separation and sharp results.',
            ],
            'canon-85mm-f-1-2-ii' => [
                'description' => $canon85_12ii,
                'excerpt' => 'Canon 85mm f/1.2L II creates signature portrait depth and luxurious background blur.',
            ],
            'canon-ef-50mm-f-1-8' => [
                'description' => $canon50_18,
                'excerpt' => 'Canon EF 50mm f/1.8 is a lightweight prime for clean portraits and low-light shooting.',
            ],
            'canon-ef-85mm-f1-4-lens' => [
                'description' => $canon85_14,
                'excerpt' => 'Canon EF 85mm f/1.4L IS blends premium portrait look with stabilization for hybrid creators.',
            ],
            'canon-rf-50mm-f-1-4-lens' => [
                'description' => $canonRf50_14,
                'excerpt' => 'Canon RF 50mm f/1.4 offers bright standard-prime versatility for modern mirrorless workflows.',
            ],
            'canon-rf-70-200mm-f2-8' => [
                'description' => $canonRf70_200,
                'excerpt' => 'Canon RF 70-200mm f/2.8 delivers flagship telephoto speed and sharpness for RF shooters.',
            ],
            'canon-ef-100mm-f-2-8l-macro' => [
                'description' => $canon100Macro,
                'excerpt' => 'Canon 100mm f/2.8L Macro captures crisp close-up detail and doubles as a portrait lens.',
            ],
            'nikon-24-70mm-2-8' => [
                'description' => $nikon24_70,
                'excerpt' => 'Nikon 24-70mm f/2.8 is a pro all-round zoom for events, portraits, and documentary work.',
            ],
            'nikon-50mm-1-8-lens' => [
                'description' => $nikon50_18,
                'excerpt' => 'Nikon 50mm f/1.8 is a compact prime for natural perspective and dependable low-light use.',
            ],
            'nikon-70-200mm-f-2-8' => [
                'description' => $nikon70_200,
                'excerpt' => 'Nikon 70-200mm f/2.8 delivers telephoto reach and pro consistency for live event coverage.',
            ],
            'sigma-150-600mm' => [
                'description' => $sigma150_600,
                'excerpt' => 'Sigma 150-600mm provides extreme telephoto reach for wildlife, sports, and distant subjects.',
            ],
            'sigma-24-70mm-2-8' => [
                'description' => $sigma24_70,
                'excerpt' => 'Sigma 24-70mm f/2.8 combines pro sharpness and everyday versatility in one reliable zoom.',
            ],
            'sigma-35mm-1-4' => [
                'description' => $sigma35_14,
                'excerpt' => 'Sigma 35mm f/1.4 offers cinematic storytelling perspective with excellent low-light performance.',
            ],
            'sigma-35mm-f-1-4' => [
                'description' => $sigma35_14,
                'excerpt' => 'Sigma 35mm f/1.4 offers cinematic storytelling perspective with excellent low-light performance.',
            ],
            'sigma-50mm-1-4' => [
                'description' => $sigma50_14,
                'excerpt' => 'Sigma 50mm f/1.4 delivers premium standard-prime rendering for portraits and branded content.',
            ],
            'sigma-70-200mm-f-2-8' => [
                'description' => $sigma70_200,
                'excerpt' => 'Sigma 70-200mm f/2.8 is a versatile telephoto zoom for portraits, events, and stage work.',
            ],
            'sigma-85mm-1-4' => [
                'description' => $sigma85_14,
                'excerpt' => 'Sigma 85mm f/1.4 creates striking portrait separation and refined professional image character.',
            ],
            'sigma-sony-14-24mm' => [
                'description' => $sigmaSony14_24,
                'excerpt' => 'Sigma 14-24mm for Sony captures expansive scenes for architecture and immersive wide visuals.',
            ],
            'sigma-sony-85mm-lens' => [
                'description' => $sigmaSony85,
                'excerpt' => 'Sigma Sony 85mm lens provides premium portrait compression and smooth cinematic bokeh.',
            ],
            'sigma-24-70mm-f-2-8-dg-dn-art-lens-for-sony' => [
                'description' => $sigma24_70,
                'excerpt' => 'Sigma 24-70mm DG DN Art for Sony is a pro standard zoom built for hybrid creators.',
            ],
            '__trashed' => [
                'description' => $sonyGm50_14,
                'excerpt' => 'Sony G Master 50mm f/1.4 delivers flagship prime clarity and depth for creative workflows.',
            ],
            'sony-g-master-70-200mm-f-2-8' => [
                'description' => $sonyGm70_200,
                'excerpt' => 'Sony G Master 70-200mm f/2.8 is a premium telephoto zoom for mission-critical productions.',
            ],
            'tamron-70-200mm-f-2-8' => [
                'description' => $tamron70_200,
                'excerpt' => 'Tamron 70-200mm f/2.8 offers telephoto flexibility and strong value for event coverage.',
            ],
            'yongnuo-50mm-f1-8-af' => [
                'description' => $yongnuo50_18,
                'excerpt' => 'Yongnuo 50mm f/1.8 AF is a budget-friendly prime for portraits and low-light content.',
            ],
        ];
    }

    private static function lighting(): array
    {
        return [
            'amaran-150c' => [
                'description' => "The amaran 150c is a 150W RGBWW Bowens-mount point source designed for creators who need fast color control without carrying a heavy cinema head. Its 2,500K-7,500K CCT range, full HSI color tools, and strong color metrics make it practical for skin tones, product shots, and stylized music visuals.\n\nFor Ghana shoots, this unit is a smart pick when you need one lamp to cover interviews, events, and social content in mixed light. Pair it with softboxes or projection modifiers, run quiet fan modes for dialogue, and build polished lighting setups even in tight apartments or church interiors.",
                'excerpt' => "150W RGBWW Bowens light with 2,500K-7,500K control, ideal for flexible interviews, content, and creative color scenes in Ghana."
            ],
            'amaran-300c' => [
                'description' => "The amaran 300c steps up output for teams that want full-color control with more punch than compact LEDs. It combines RGBWW color mixing, wide CCT adjustment, and professional color fidelity, giving filmmakers room to shape both natural and stylized looks.\n\nOn commercial and wedding jobs around Accra, this fixture helps you maintain consistent key light while still matching practicals and ambient daylight. With Bowens compatibility, you can quickly move from soft beauty light to hard dramatic setups without changing your core fixture.",
                'excerpt' => "High-output RGBWW Bowens fixture for productions needing stronger output, accurate color, and versatile modifier support."
            ],
            'aputure-ls-600d-pro-daylight-led-monolight' => [
                'description' => "Aputure's LS 600d Pro is a high-output daylight COB built for demanding professional sets. It is balanced at 5600K and engineered for serious throw, weather-resistant field use, and robust control options, making it a dependable flagship key or sun-matching source.\n\nIn Ghana's bright outdoor environments, the 600d Pro gives crews the horsepower to compete with midday light or push clean beams through diffusion and frames. It is a premium choice for TVCs, narrative work, and large event coverage where reliability and intensity matter most.",
                'excerpt' => "Flagship 5600K COB with massive output and pro reliability, built for outdoor daylight balancing and large productions."
            ],
            'aputure-ls-c300d-ii-led-monolight' => [
                'description' => "The LS C300d II is a proven daylight LED monolight known for strong output, stable 5600K color, and dependable build quality. It supports Bowens modifiers and professional control workflows, making it a frequent choice for documentary, interview, and branded content setups.\n\nFor local rental workflows, it hits an excellent middle ground between portability and power. Crews can use it as a clean key, a hard backlight, or a bounced source, and still move quickly between church events, studio shoots, and on-location corporate projects.",
                'excerpt' => "Trusted 5600K LED monolight with strong output and Bowens flexibility for interviews, branded content, and event work."
            ],
            'godox-tl120-rgb-led-tube-light' => [
                'description' => "The Godox TL120 is a 120cm RGB tube light designed for practical placement, edge lighting, and creative color accents. With RGB effects, CCT control, and battery-powered operation, it works well where traditional light stands are hard to place.\n\nFor Ghana music videos and fashion shoots, TL120 tubes are excellent for background texture, car interiors, and nightclub-style scenes. They are also useful for subtle fill in weddings and social media content when you need lightweight tools that can hide easily in frame-friendly positions.",
                'excerpt' => "120cm RGB tube with battery power and effects, perfect for creative accent lighting, practical placement, and music visuals."
            ],
            'neewer-660-pro-rgb' => [
                'description' => "The Neewer 660 Pro RGB panel gives creators an affordable all-in-one source for bi-color and RGB work. It offers broad CCT adjustment, hue control, and dimming in a familiar panel format, making it easy to use for small crews and hybrid photo-video teams.\n\nOn fast jobs in Accra and Kumasi, this fixture is useful as fill, hair light, or background color splash. It is especially practical for creators who need lightweight kits for interviews, tutorials, and product content without sacrificing basic color flexibility.",
                'excerpt' => "Affordable RGB/bi-color panel for creators needing quick, flexible fill and color effects on lightweight productions."
            ],
            'tolifo-200w' => [
                'description' => "The Tolifo 200W is a practical high-power LED option for creators who need stronger key light than small panels can deliver. Its output class makes it suitable for interview keys, portrait setups, and controlled narrative scenes where consistent illumination is required.\n\nFor rental users in Ghana, it provides a cost-effective step into more professional lighting ratios, especially when paired with diffusion and grids. It is a dependable choice for YouTube studios, church media teams, and small commercial crews.",
                'excerpt' => "200W-class LED option that delivers stronger key light for interviews, portrait work, and small commercial productions."
            ],
            'tolifo-500b-elite' => [
                'description' => "The Tolifo 500B Elite is aimed at productions that need high-output bi-color performance with greater control over warm and cool ambience. Its power class is suited to larger spaces, event stages, and sets where lower-watt fixtures struggle to maintain exposure.\n\nIn Ghana's mixed lighting environments, this unit is useful for balancing tungsten practicals at night or cooler daylight in daytime venues. It is a strong rental option for multicam worship coverage, event documentaries, and larger interview sets.",
                'excerpt' => "Powerful bi-color fixture for larger venues and mixed-light shoots, with the output needed for multicam and event work."
            ],
            'yidoblo-dy1080' => [
                'description' => "The Yidoblo DY1080 ring light is a straightforward beauty and portrait tool built for flattering, even facial illumination. Its circular form factor creates smooth catchlights and soft frontal light that works well for talking-head video, makeup content, and livestreams.\n\nFor Ghana creators producing daily social content, this is an easy plug-and-shoot option that speeds setup in homes, salons, and small studios. It is especially useful for presenters who want clean skin tone rendering with minimal lighting complexity.",
                'excerpt' => "Ring-light solution for flattering beauty, livestream, and talking-head content with fast setup and smooth facial light."
            ],
            'godox-ad200pro-ii-overview' => [
                'description' => "The Godox AD200Pro II is a compact 200Ws battery strobe designed for photographers who need portability without giving up serious flash control. It supports wireless triggering, high-speed sync workflows, and flexible head options for different shaping styles.\n\nFor Ghana wedding and event shooters moving between indoor halls and harsh outdoor sun, this flash gives dependable pop in a lightweight package. It is ideal when you need rapid setup, location mobility, and enough power to separate subjects from busy backgrounds.",
                'excerpt' => "Compact 200Ws battery strobe with pro wireless control, ideal for mobile wedding, portrait, and event photography."
            ],
            'godox-ad600bm' => [
                'description' => "The Godox AD600BM is a 600Ws manual battery monolight built for photographers who prefer straightforward power control and repeatable output. It delivers strong flash energy with Bowens accessory compatibility, making it useful for location portraits and dramatic off-camera lighting.\n\nIn Ghana's outdoor portrait and fashion scenes, the AD600BM is excellent for overpowering daylight and maintaining bold contrast. It is a practical rental choice for shooters who want big strobe performance without relying on TTL automation.",
                'excerpt' => "Manual 600Ws battery strobe with Bowens mount, great for strong daylight control in portraits and fashion shoots."
            ],
            'godox-ad600pro-ii' => [
                'description' => "The Godox AD600Pro II builds on a trusted 600Ws platform with faster workflow features, broad power control, high-speed sync, and improved user interface behavior. It also includes an upgraded modeling light approach, making it more usable for hybrid stills and video pre-lighting.\n\nFor high-end Ghana productions, this flash is a workhorse for fashion campaigns, pre-wedding sessions, and commercial sets that demand reliable recycling and consistent results. It is a premium rental option when timing, speed, and control directly affect deliverables.",
                'excerpt' => "Advanced 600Ws battery strobe with HSS and refined controls for premium fashion, commercial, and location production."
            ],
            'godox-v1-speedlight' => [
                'description' => "The Godox V1 Speedlight is a round-head on-camera flash known for smoother falloff and natural-looking flash transitions. It supports TTL and HSS systems, while its rechargeable battery platform helps reduce downtime during long event coverage.\n\nFor Ghana wedding photographers and content teams, the V1 is excellent for fast-moving receptions, church ceremonies, and run-and-gun portraits. Used on or off camera, it delivers clean, controllable light with quick handling in real client environments.",
                'excerpt' => "Round-head TTL speedlight with HSS and rechargeable battery, ideal for weddings, events, and fast on-location shooting."
            ],
        ];
    }

    private static function audio(): array
    {
        return [
            'discover-the-boya-k4-wireless-mic-elevate-your-audio-experience' => [
                'description' => "The BOYA K4 wireless mic system is built for creators who need better spoken-word clarity than built-in camera or phone microphones can provide. It is designed for quick pairing, compact wearability, and practical voice capture for solo presenters and interviews.\n\nFor Ghana creators covering events, church media, and social clips, this kit helps deliver cleaner dialogue in busy locations. It is a budget-friendly rental choice when you want immediate improvement in vocal presence without a complicated audio chain.",
                'excerpt' => "Entry-friendly wireless mic kit for clearer speech capture in vlogs, interviews, and mobile content workflows."
            ],
            'dji-mic-2-wireless-microphone' => [
                'description' => "DJI Mic 2 is a modern wireless microphone system built for creators who need robust dialogue capture and backup confidence. It offers long-range transmission, intelligent noise control options, and internal recording with 32-bit float capability for safer levels in unpredictable scenes.\n\nIn Ghana's event and street-reporting environments, this system is excellent for interviews, creator content, and documentary pickups where clean audio is critical. Direct compatibility with phones, cameras, and creator rigs makes it a premium rental tool for fast productions.",
                'excerpt' => "Pro wireless audio system with internal 32-bit float recording and long-range transmission for reliable creator workflows."
            ],
            'hollyland-lark-max' => [
                'description' => "The Hollyland Lark Max is a dual-channel wireless mic system focused on compact operation and dependable voice quality. It includes on-transmitter recording support and practical controls that help creators maintain usable dialogue in dynamic shooting conditions.\n\nFor Ghana content teams handling interviews, wedding stories, and mobile video shoots, Lark Max provides a strong balance of portability and professional results. It is a smart rental option when you need two-person dialogue coverage with minimal setup time.",
                'excerpt' => "Dual-channel wireless mic system with onboard recording, ideal for interviews and two-person creator productions."
            ],
            'rhode-wireless-go-ii' => [
                'description' => "The RODE Wireless GO II is a compact dual-transmitter wireless system that became a standard for creator and documentary workflows. It supports two-channel recording, onboard transmitter memory, and flexible connectivity for cameras and mobile devices.\n\nIn Ghana production contexts, it works well for interviews, wedding snippets, and quick field updates where speed matters. It is an easy rental recommendation for teams that want reliable spoken audio without carrying a full recorder bag.",
                'excerpt' => "Compact dual-channel wireless mic kit with onboard recording, great for fast interviews and creator content."
            ],
            'rhode-wireless-pro' => [
                'description' => "The RODE Wireless PRO is a flagship compact wireless system designed for high-trust production audio. It features 32-bit float onboard recording, timecode-ready workflows, and strong accessory support for camera and mobile integration.\n\nFor Ghana commercial shoots and multicamera interviews, this kit helps protect takes when levels change unexpectedly and deadlines are tight. It is ideal for crews that want premium wireless convenience with post-production safety built in.",
                'excerpt' => "Flagship compact wireless system with 32-bit float recording and pro workflow features for high-stakes shoots."
            ],
            'shure-sm7b-microphone' => [
                'description' => "The Shure SM7B is a legendary broadcast dynamic microphone known for smooth vocal tone, controlled presence, and excellent rejection of room noise when positioned correctly. It is a studio staple for podcasting, voiceover, and music applications that demand rich, focused voice capture.\n\nFor Ghana podcast studios and church media rooms, the SM7B provides a polished sound that listeners immediately recognize as professional. It is best paired with proper gain staging and clean preamp support for optimal performance.",
                'excerpt' => "Broadcast-standard dynamic microphone delivering rich, controlled vocals for podcasts, voiceover, and studio speech."
            ],
            'zoom-h5-field-recorder' => [
                'description' => "The Zoom H5 is a portable handheld recorder built for location sound, interviews, and backup recording in unpredictable environments. Its interchangeable capsule ecosystem, XLR inputs, and reliable battery operation make it a practical tool for solo operators and small crews.\n\nAcross Ghana documentary and event jobs, the H5 is useful for capturing ambient sound, clean dialogue, and safety tracks away from camera position. It is a dependable rental option for teams that need portable multichannel recording without complexity.",
                'excerpt' => "Portable field recorder with XLR inputs and capsule flexibility for interviews, ambience, and reliable location backup."
            ],
            'zoom-h8-handy-recorder' => [
                'description' => "The Zoom H8 expands portable recording with more inputs, app-style workflow modes, and stronger multitrack flexibility for field and production audio. It is designed for podcasters, filmmakers, and event teams needing broader channel capacity in one compact unit.\n\nFor Ghana live sessions, panel discussions, and multicam productions, the H8 helps capture multiple speakers cleanly while staying mobile. It is an excellent rental choice when your project outgrows small two-channel systems.",
                'excerpt' => "High-capacity handheld recorder for multi-speaker sessions, events, and flexible field multitrack capture."
            ],
        ];
    }

    private static function gimbalsAndDrones(): array
    {
        return [
            'dji-ronin-rs2-pro' => [
                'description' => "The DJI RS 2 Pro is a professional 3-axis stabilizer built with lightweight carbon-fiber architecture and payload capacity for serious camera packages. It supports advanced focus and transmission ecosystems, giving filmmakers smoother movement and stronger control on narrative and commercial sets.\n\nFor Ghana productions shooting weddings, music videos, and branded content, RS 2 Pro remains a reliable cinema-style gimbal that handles long days on location. It is ideal when you need stable motion shots without stepping into large rig complexity.",
                'excerpt' => "Pro 3-axis gimbal with strong payload support and advanced control for cinematic moving shots on location."
            ],
            'dji-ronin-rs3' => [
                'description' => "The DJI RS 3 modernizes solo-operator stabilization with quick setup features, automated axis behavior, and dependable payload support for mirrorless camera rigs. It is optimized for speed, reducing balancing friction so creators can focus on shot design.\n\nIn Ghana's fast event environments, RS 3 helps videographers move from handheld prep to stabilized coverage quickly. It is a practical rental favorite for weddings, real estate walk-throughs, and social-first brand filmmaking.",
                'excerpt' => "Fast, creator-friendly gimbal that streamlines setup and delivers stable footage for events and branded video."
            ],
            'dji-ronin-rs4' => [
                'description' => "The DJI RS 4 is a newer-generation stabilizer with improved workflow integration, stronger stabilization behavior, and efficient balancing for modern camera builds. It is designed for operators who need dependable performance across rapid scene changes.\n\nFor Ghana commercial teams and independent filmmakers, the RS 4 is a smart rental when mobility and speed are equally important. It supports polished motion language in tight city spaces, interiors, and outdoor lifestyle sequences.",
                'excerpt' => "Next-gen DJI stabilizer offering refined balance workflow and reliable cinematic motion for modern camera setups."
            ],
            'dji-ronin-r4-pro' => [
                'description' => "The DJI RS 4 Pro class platform targets higher-end cinema and hybrid production rigs with greater control depth and payload confidence. It is designed for demanding workflows where focus systems, heavier lenses, and extended shoot schedules are part of the plan.\n\nOn larger Ghana sets, this gimbal class is ideal for commercial storytelling, automotive shots, and premium wedding films that require consistent motion quality. It is a top-tier rental choice when production value is a core deliverable.",
                'excerpt' => "High-end RS 4 Pro-class stabilization for heavier rigs and premium cinematic productions with complex workflows."
            ],
            'zhiyun-crane-3s' => [
                'description' => "The Zhiyun Crane 3S is built for heavier cinema-style payloads and modular rigging flexibility. Its design supports larger cameras and accessory combinations, making it suitable for productions that need stabilized movement with pro-bodied systems.\n\nFor Ghana crews handling RED or cinema-heavy mirrorless builds, the Crane 3S offers valuable payload headroom for demanding shots. It is a dependable rental option when smaller gimbals cannot safely carry the required setup.",
                'excerpt' => "Heavy-duty gimbal with modular design and high payload support for cinema cameras and larger production rigs."
            ],
            'zhiyun-crane-4' => [
                'description' => "The Zhiyun Crane 4 continues the brand's stabilizer line with improved ergonomics and creator-focused control refinements for modern camera work. It is suited to teams that want smooth movement, practical handling, and broad compatibility for hybrid video shoots.\n\nIn Ghana's mixed indoor-outdoor productions, this gimbal supports efficient capture of reveal shots, tracking moves, and event coverage. It is a versatile rental option for crews balancing performance with portability.",
                'excerpt' => "Versatile modern gimbal with improved handling for smooth tracking shots across event and commercial productions."
            ],
            'dji-mavic-3-classic' => [
                'description' => "The DJI Mavic 3 Classic centers on a high-quality Hasselblad camera experience with strong flight reliability and advanced obstacle sensing. It delivers professional imaging capability in a foldable drone platform that is practical for regular production deployment.\n\nFor Ghana real estate, tourism, and event cinematography, Mavic 3 Classic offers clean aerial detail with efficient setup time. It is a premium rental choice when clients expect cinematic overheads and consistent image quality.",
                'excerpt' => "Premium foldable drone with Hasselblad imaging and reliable flight tools for cinematic real estate and event aerials."
            ],
            'dji-mini-3-pro' => [
                'description' => "The DJI Mini 3 Pro combines sub-250g portability with advanced camera features and intelligent flight safety tools. It provides strong video quality, flexible shooting modes, and practical obstacle sensing for creators who need lightweight aerial coverage.\n\nFor Ghana operators traveling between locations, this drone is excellent for quick deployment at weddings, outdoor portraits, and social campaigns. It is an efficient rental option when you want professional-looking aerial shots with minimal logistical burden.",
                'excerpt' => "Lightweight sub-250g drone delivering pro-looking aerial video with smart safety features and quick deployment."
            ],
            'dji-mini-4-pro' => [
                'description' => "The DJI Mini 4 Pro expands compact-drone capability with improved sensing, intelligent tracking, and high-quality imaging features in a highly portable body. It is designed for creators who need strong autonomous support while maintaining lightweight travel convenience.\n\nFor Ghana production teams covering resorts, city visuals, and destination events, Mini 4 Pro offers reliable cinematic capture with minimal setup overhead. It is a top rental pick for agile aerial storytelling in fast-moving schedules.",
                'excerpt' => "Advanced compact drone with improved sensing and tracking, ideal for agile cinematic aerial storytelling."
            ],
        ];
    }

    private static function accessories(): array
    {
        return [
            '1-5m-hdmi-cable' => [
                'description' => 'This standard HDMI lead is ideal for short camera-to-monitor and switcher-to-display runs where signal integrity and fast setup matter. It supports the common HD and UHD workflows used in live production, with molded strain relief that handles repeated patching on set.' . "\n\n" .
                    'For rentals, the 1-5m length keeps rigs clean and reduces cable clutter around tripods, interview stations, and streaming desks. It is the practical everyday cable for reliable picture handoff without overbuilding your signal path.',
                'excerpt' => 'Reliable short-run HDMI cable for camera, monitor, and switcher setups with clean signal delivery and easy on-set routing.',
            ],
            '100m-fibre-hdmi-cables' => [
                'description' => 'This 100m active fibre HDMI cable is built for long-distance AV runs where copper cables become unreliable. Fibre architecture is designed to maintain stable transmission over extended lengths while keeping cable weight and pull tension manageable compared with thick copper trunks.' . "\n\n" .
                    'It is a strong fit for church overflow, conference halls, and event venues where switcher and projector positions are far apart. Renters use it to push clean video to FOH or LED processors without introducing extra converters at every corner.',
                'excerpt' => 'Long-run 100m fibre HDMI for stable signal delivery across large venues, stages, and distant projector or switcher positions.',
            ],
            '105cm-softbox' => [
                'description' => 'This 105cm softbox creates a broad, flattering light source that smooths skin texture and softens shadows for interviews, portraits, and product work. Its larger diffusion face helps wrap light around subjects while preserving dimensionality when feathered correctly.' . "\n\n" .
                    'In rental workflows, it is a dependable key-light modifier for single-subject shoots and small crews. Setup is straightforward, and the size strikes a practical balance between soft quality and manageable footprint in home studios or event halls.',
                'excerpt' => '105cm softbox for broad, flattering key light in interviews, portraits, and controlled studio-style setups.',
            ],
            '120cm-softbox' => [
                'description' => 'The 120cm softbox is designed for very soft output and gentle falloff across faces, wardrobe, and background transitions. Its oversized diffusion surface is especially useful when you need polished corporate interviews, beauty content, or cinematic close framing.' . "\n\n" .
                    'For rentals, this is the modifier you choose when softness is non-negotiable and space allows a bigger fixture. It delivers a premium look with fewer harsh specular highlights, making post work faster and skin tones easier to grade.',
                'excerpt' => 'Large 120cm softbox delivering ultra-soft wrap for premium interview, beauty, and cinematic key-light setups.',
            ],
            '30m-fibre-hdmi-cables' => [
                'description' => 'The 30m fibre HDMI cable handles mid-range AV runs while preserving signal stability in demanding live environments. It is engineered for distance where passive HDMI often fails, helping maintain consistent image delivery between camera islands, switchers, and displays.' . "\n\n" .
                    'Renters choose this length for sanctuaries, boardrooms, and event floors that need more reach without introducing bulky distribution gear. It keeps cabling clean and reduces troubleshooting risk during time-sensitive productions.',
                'excerpt' => '30m active fibre HDMI for dependable mid-distance signal runs in live production and event AV workflows.',
            ],
            '50m-fibre-hdmi-cables-2' => [
                'description' => 'This unit is mapped to a 40m fibre HDMI run, giving extended reach for installations and live events where equipment positions are fixed far apart. The fibre design is intended for stable long-distance transport with less susceptibility to the losses common in long passive cables.' . "\n\n" .
                    'As a rental option, it is ideal when you need dependable point-to-point video from stage to control or projector sidewall to rack. It offers long-run confidence without overcomplicating setup with additional conversion boxes.',
                'excerpt' => '40m equivalent fibre HDMI run for reliable long-distance video routing in churches, venues, and conference setups.',
            ],
            '50m-fibre-hdmi-cables' => [
                'description' => 'This 50m fibre HDMI cable is built for robust long-run video transport in production and presentation spaces. It supports the practical needs of extended cable paths while helping preserve image consistency over distance.' . "\n\n" .
                    'For renters, 50m is a versatile sweet spot: long enough for most stage-to-booth and hall-to-projector routes, yet still fast to deploy. It reduces cable repeaters and keeps your signal chain simpler under event pressure.',
                'excerpt' => '50m fibre HDMI cable for dependable long-run signal paths between stage, control, and display positions.',
            ],
            '65cm-softbox' => [
                'description' => 'The 65cm softbox is a compact modifier for controlled soft light in tighter rooms and mobile shoots. It offers smoother highlights than bare reflectors while remaining easy to position in narrow interview corners, home studios, and small product tables.' . "\n\n" .
                    'In rental use, it is a strong choice for fast setup crews needing quality light without oversized hardware. The footprint is travel-friendly and practical for creators who frequently rebalance between portability and professional output.',
                'excerpt' => 'Compact 65cm softbox for soft controlled lighting in small spaces, travel shoots, and quick interview setups.',
            ],
            '85cm-softbox' => [
                'description' => 'This 85cm softbox delivers a balanced blend of softness and punch, suitable for talking heads, worship team portraits, and branded video content. The size provides meaningful wrap while maintaining manageable spill and easier boom placement.' . "\n\n" .
                    'For rentals, it is a flexible all-rounder that adapts quickly between key and fill roles. Teams pick it when they want a polished look, faster rigging, and fewer compromises in medium-sized interiors.',
                'excerpt' => 'Versatile 85cm softbox balancing wrap, control, and portability for interviews, portraits, and branded content.',
            ],
            '90cm-softbox' => [
                'description' => 'The 90cm softbox offers broad diffusion with enough directional control for cinematic interview and portrait setups. It softens facial contrast and helps maintain a clean transition from key to shadow, especially with modern LED COB fixtures.' . "\n\n" .
                    'In rental scenarios, this size is favored for church media teams and event creators who need repeatable lighting quality week after week. It is large enough for premium softness but still efficient for mobile deployment.',
                'excerpt' => '90cm softbox for smooth, cinematic key light with practical control in recurring production setups.',
            ],
            'acsoon-cineview-se' => [
                'description' => 'Accsoon CineView SE uses dual-band 2.4GHz + 5GHz transmission with quoted sub-50ms latency and up to 1200ft line-of-sight range in controlled conditions. It supports HDMI and SDI up to 1080p60, making it a practical monitoring link for hybrid camera fleets.' . "\n\n" .
                    'For rental productions, it is valuable when directors, focus pullers, or clients need untethered confidence monitors without costly wireless ecosystems. The system is compact, quick to pair, and dependable for interviews, worship broadcasts, and run-and-gun sets.',
                'excerpt' => 'Dual-band Accsoon wireless video kit with sub-50ms latency and up to 1200ft LOS range for 1080p monitoring.',
            ],
            'atem-mini-extreme-pro-iso' => [
                'description' => 'This profile targets the ATEM Mini Extreme ISO class workflow: 8 HDMI inputs, hardware streaming, multiview, and ISO recording of all sources plus program. Blackmagic specs note up to 70Mb/s H.264 ISO files and automatic DaVinci Resolve project generation for post-event fixes.' . "\n\n" .
                    'In rentals, it is the right switcher for multi-camera church services, conferences, and hybrid events where immediate live output and editable records are both required. Operators can stream, record isolated feeds, and turn around highlights quickly with less rework.',
                'excerpt' => '8-input HDMI live switcher workflow with ISO recording, multiview, and fast DaVinci post handoff for events.',
            ],
            'atem-mini-pro' => [
                'description' => 'ATEM Mini Pro provides 4 HDMI inputs, direct Ethernet streaming via RTMP, USB webcam output, and multiview monitoring. Manufacturer specs highlight standards conversion on all inputs plus H.264 USB recording for streamlined live delivery.' . "\n\n" .
                    'For rental teams, it is a compact control hub for podcasts, worship streams, and classroom broadcasts. It offers professional switching features without a heavy rack footprint, helping smaller crews run cleaner shows with fewer moving parts.',
                'excerpt' => '4-input ATEM switcher with direct RTMP streaming, USB webcam out, and multiview for compact live productions.',
            ],
            'atem-mini-pro-iso' => [
                'description' => 'ATEM Mini Pro ISO builds on the Pro platform with isolated recording of each HDMI input plus the program output. It also saves a DaVinci Resolve project file, enabling fast timeline reconstruction and shot replacement after the live event.' . "\n\n" .
                    'This is a high-value rental for productions that cannot risk a one-take-only result. Churches, webinars, and panel discussions benefit from a live stream now and full editorial flexibility later, all from one compact switcher.',
                'excerpt' => 'ATEM Mini Pro ISO adds per-input recording and Resolve project export for live-now, edit-later workflows.',
            ],
            'atem-sdi-pro-iso' => [
                'description' => 'ATEM SDI Pro ISO is built for SDI-centric production with 4 x 3G-SDI inputs, hardware streaming, and ISO capture of all inputs plus program. Official specs include H.264 recording up to 70Mb/s and separate audio files with a generated Resolve project for finishing.' . "\n\n" .
                    'For renters working with professional camera chains, this model reduces HDMI conversion points and improves operational confidence. It is a strong fit for broadcast-style worship, studio panels, and event control rooms that prefer SDI robustness.',
                'excerpt' => '4-input SDI live switcher with ISO recording, hardware streaming, and Resolve-ready files for post correction.',
            ],
            'batmax-npf-battery' => [
                'description' => 'BATMAX NP-F batteries follow the Sony L-series form factor used by many monitors, LED panels, and wireless video systems. Typical listings use 7.2V nominal output and multiple capacities across NP-F550, NP-F750, and NP-F970 sizes to match different runtime and weight needs.' . "\n\n" .
                    'As a rental accessory, this is practical set power for long interview days and mobile rigs where wall power is limited. Clients can scale runtime by battery size and keep production moving without frequent tethered charging breaks.',
                'excerpt' => 'Sony NP-F style battery option for monitors, lights, and wireless gear, with scalable runtime across form factors.',
            ],
            'c-stand' => [
                'description' => 'A C-stand provides stable support for lights, flags, scrims, and grip arms in professional sets. Its steel construction, turtle base style footprint, and gobo head workflow make it a core tool for shaping light safely and repeatably.' . "\n\n" .
                    'Rental teams rely on C-stands when precision placement matters more than speed-only setup. It is ideal for negative fill, overhead diffusion, and boom-mounted fixtures where lightweight stands can drift or tip under load.',
                'excerpt' => 'Heavy-duty C-stand for secure light shaping, flagging, and boom support in controlled production environments.',
            ],
            'canon-battery-charger' => [
                'description' => 'Canon battery chargers in this class are designed to manage safe charging cycles, status indication, and battery health for LP-series packs. OEM charge logic helps protect against overcharge behavior and keeps turnaround predictable between shoot blocks.' . "\n\n" .
                    'In rental workflows, a dedicated charger is essential for overnight prep and quick battery rotation during multi-camera days. It reduces downtime and ensures packs are ready for call time rather than guessing from partial charge states.',
                'excerpt' => 'OEM Canon charger for reliable LP-series battery turnaround, status visibility, and safer multi-day shoot prep.',
            ],
            'canon-camcorder-battery' => [
                'description' => 'This Canon camcorder battery category is intended for long-form recording needs such as worship coverage, events, and interviews. Manufacturer-style packs prioritize stable discharge curves and consistent runtime in video-focused duty cycles.' . "\n\n" .
                    'For rentals, it is a practical backup strategy when AC access is limited or mobility is required. A spare camcorder battery keeps continuous recording possible during processions, stage movement, and location transitions.',
                'excerpt' => 'Canon camcorder battery option for dependable runtime during long-form event and worship video coverage.',
            ],
            'canon-e6n-battery' => [
                'description' => 'Canon LP-E6N is a 7.2V, 1865mAh lithium-ion pack widely used across EOS DSLR and mirrorless bodies. It is known for broad cross-body compatibility and reliable performance in both stills bursts and hybrid video sessions.' . "\n\n" .
                    'As a rental spare, LP-E6N is a safe baseline power option for creators running long shoot days with limited charging windows. It helps maintain continuity across A/B camera rotations without changing battery ecosystems mid-production.',
                'excerpt' => 'LP-E6N 7.2V 1865mAh Canon battery for dependable cross-body compatibility in stills and video workflows.',
            ],
            'feelworld-onscreen-monitor' => [
                'description' => 'Feelworld on-camera monitors are typically designed to give larger, clearer framing and focus confidence than in-camera displays. Common models provide HDMI monitoring features like peaking, zebra, waveform tools, and LUT preview support depending on unit class.' . "\n\n" .
                    'In rental use, these monitors are highly effective for solo operators and small crews that need better exposure judgment and client visibility. They speed up decision making on set and reduce avoidable focus errors in post.',
                'excerpt' => 'On-camera field monitor for better focus, exposure confidence, and director/client viewing during production.',
            ],
            'godox-x-pro-ii-trigger' => [
                'description' => 'Godox XPro II trigger operates on the 2.4GHz X system with quoted 100m range, 32 channels, and expanded group control. It supports TTL, manual, stroboscopic modes, plus HSS up to 1/8000s, and adds Bluetooth app control for remote adjustments.' . "\n\n" .
                    'For rentals, it is ideal when lighting setups are complex and speed matters. Photographers can make fast group-level changes from camera position and keep sessions flowing without repeatedly walking to each light.',
                'excerpt' => 'Advanced Godox trigger with TTL/HSS, 2.4GHz control, Bluetooth app support, and fast multi-group lighting control.',
            ],
            'godox-x-pro-trigger' => [
                'description' => 'The original Godox XPro trigger is a proven 2.4GHz radio commander with 32 channels, multi-group control, TTL support, and HSS up to 1/8000s. It is designed for reliable off-camera flash coordination across portraits, events, and location shoots.' . "\n\n" .
                    'As a rental tool, it provides stable control over the Godox X ecosystem without adding complexity. It remains a dependable choice for photographers who prioritize straightforward physical controls and repeatable flash behavior.',
                'excerpt' => 'Proven Godox XPro radio trigger with TTL/HSS and 32-channel multi-group off-camera flash control.',
            ],
            'gdox-x2t-trigger' => [
                'description' => 'Godox X2T trigger adds practical controls for fast event pacing: 2.4GHz radio, 32 channels, 5 groups, and support for TTL plus HSS up to 1/8000s. The design also includes Bluetooth app connectivity and a quick-lock shoe for more secure camera mounting.' . "\n\n" .
                    'Rental users value this unit for weddings, church programs, and product sets where light power is adjusted often. It balances strong wireless reliability with a compact profile and intuitive group access buttons.',
                'excerpt' => 'Compact Godox X2T trigger with TTL/HSS, Bluetooth control, and reliable 2.4GHz multi-group flash operation.',
            ],
            'godox-x3-trigger-nikon' => [
                'description' => 'Godox X3-N for Nikon is a compact touchscreen trigger with internal rechargeable battery, 2.4GHz control, and up to 100m range. It supports Nikon TTL, manual/multi modes, and HSS up to 1/8000s while maintaining full Godox X-system compatibility.' . "\n\n" .
                    'For rentals, this is a clean option when photographers want modern controls and minimal hot-shoe bulk. USB-C charging and quick menu access make it efficient for travel jobs, fast sessions, and lightweight kits.',
                'excerpt' => 'Rechargeable Godox X3-N Nikon trigger with touchscreen control, TTL/HSS support, and compact travel-ready design.',
            ],
            'godox-x3-trigger-sony' => [
                'description' => 'Godox X3-S for Sony brings the same ultra-compact X3 platform with Sony TTL integration, 2.4GHz radio control, and touchscreen operation. It supports high-speed sync, exposure compensation workflows, and quick control of compatible Godox lights.' . "\n\n" .
                    'In rental scenarios, it is excellent for hybrid creators using Sony bodies who need speed and minimal rig weight. The interface is simple to learn, helping teams move quickly between portrait, event, and content setups.',
                'excerpt' => 'Compact Godox X3-S Sony trigger with touchscreen UI, rechargeable power, and full TTL/HSS flash control.',
            ],
            'godox-x3-trigger' => [
                'description' => 'The Godox X3 family is a minimal touchscreen trigger line built around the 2.4GHz X wireless platform. Typical specs include internal 850mAh battery, USB-C charging, 32 channels, and support for TTL/manual/multi modes with HSS capability.' . "\n\n" .
                    'As a rental default, X3 triggers are great for creators who want faster menu interaction and less camera-top weight than larger transmitters. They are particularly useful in mobile kits where every gram and minute counts.',
                'excerpt' => 'Modern touchscreen Godox X3 trigger platform with rechargeable battery and fast TTL/HSS wireless flash control.',
            ],
            'hdmi-mini-to-male-hdmi-adapter' => [
                'description' => 'This adapter converts mini HDMI camera outputs to full-size HDMI connections for monitors, switchers, and capture devices. It is a critical small part in many DSLR and mirrorless video kits where cameras use compact output ports.' . "\n\n" .
                    'For rentals, having this adapter prevents avoidable signal downtime during setup and camera swaps. It is the kind of inexpensive but essential accessory that keeps production moving when connector types do not match.',
                'excerpt' => 'Mini-to-full HDMI adapter for connecting camera outputs to standard monitor, switcher, and capture inputs.',
            ],
            'hollyland-mrs-400s-pro' => [
                'description' => 'Hollyland Mars 400S Pro is an SDI/HDMI wireless video system rated around 400ft LOS with quoted low-latency transmission near 0.1s class, and minimum figures around 0.08s in ideal conditions. It supports common 1080p production formats and app-assisted monitoring workflows.' . "\n\n" .
                    'Rental crews use it for cable-free director and focus monitoring in small to mid-size venues. It is a practical bridge between affordability and pro connectivity when both HDMI and SDI cameras are in the same show.',
                'excerpt' => 'Mars 400S Pro wireless SDI/HDMI video link with low-latency monitoring and flexible on-set deployment.',
            ],
            'hollyland-mars-400s-pro-ii' => [
                'description' => 'Mars 400S Pro II updates the line with quoted 450ft LOS range, 70ms HD-mode latency, and SDI+HDMI dual-port flexibility. It also supports HollyView app monitoring and multi-receiver workflows for collaborative production environments.' . "\n\n" .
                    'In rental terms, it is a dependable wireless monitor path for events, interviews, and camera-director handoff where cables are impractical. The improved latency profile helps operators make more confident timing and focus decisions.',
                'excerpt' => 'Updated Mars 400S Pro II wireless kit with 450ft range, 70ms latency, and SDI/HDMI flexibility.',
            ],
            'hollyland-mars-4k' => [
                'description' => 'Hollyland Mars 4K is designed for wireless 4K30 HDMI workflows with SDI/HDMI support and quoted 450ft LOS range. Manufacturer data highlights low-latency transmission around 0.06s under test conditions and variable bitrates for stability tuning.' . "\n\n" .
                    'For rentals, Mars 4K is ideal when teams need higher-resolution monitoring and broader format compatibility without stepping into premium cinema-link costs. It suits commercial shoots, worship media teams, and advanced creator rigs.',
                'excerpt' => 'Wireless 4K30-capable Mars system with SDI/HDMI support, 450ft LOS range, and low-latency monitoring.',
            ],
            'hollyland-pyro-h-4k' => [
                'description' => 'Hollyland Pyro H is an HDMI-focused wireless system supporting up to 4K30 transmission, dual-band 2.4/5GHz operation, and quoted 1300ft LOS range in standard mode. It also offers HDMI loop-out, smart channel tools, and latency figures around 60ms class.' . "\n\n" .
                    'Rental users benefit when they need long-range HDMI monitoring with simple setup and scalable receiver options. It is particularly useful for roaming camera teams, event floors, and live sets that demand flexible monitor distribution.',
                'excerpt' => 'HDMI-focused Pyro H wireless system with 4K30 support, dual-band transmission, and extended monitoring range.',
            ],
            'hollyland-pyro-s' => [
                'description' => 'Hollyland Pyro S extends the Pyro platform with both HDMI and SDI I/O, support for up to four receivers, and quoted range up to 1300ft LOS. Product materials cite low-latency performance around 50ms and dual-band/auto-hopping behavior for cleaner links in congested RF spaces.' . "\n\n" .
                    'As a rental choice, it is excellent for professional mixed-camera sets that need robust connectivity and multi-user monitoring. It brings stronger operational flexibility for film crews, live events, and broadcast-style field production.',
                'excerpt' => 'Pyro S wireless video with HDMI/SDI I/O, up to 4 receivers, long range, and low-latency dual-band performance.',
            ],
            'lexar-128gb-high-performance-sd-card' => [
                'description' => 'This Lexar 128GB high-performance SD category targets UHS-I workflows with Class 10/U3/V30 style performance depending on series. Typical product lines emphasize 4K-capable sustained write classes and faster read throughput for quicker offload between shoot segments.' . "\n\n" .
                    'For rentals, it is a practical media option for hybrid cameras recording high-bitrate HD and 4K clips. The 128GB capacity balances shoot duration and card management so crews can maintain continuity without constant swaps.',
                'excerpt' => '128GB UHS-I Lexar SD media for dependable 4K-capable recording and faster transfer in production workflows.',
            ],
            'lexar-64gb-sd-card' => [
                'description' => 'The 64GB Lexar SD option serves short-to-medium capture sessions with common UHS-I Class 10/U3/V30 performance tiers by model line. It is well suited to event segments, interviews, and B-camera coverage where card turnover is part of the workflow.' . "\n\n" .
                    'In rental kits, 64GB cards simplify backup discipline and reduce risk concentration on one card. Teams can rotate media more frequently while still covering meaningful recording windows per camera.',
                'excerpt' => '64GB Lexar SD card for reliable HD/4K capture with practical media rotation in event and interview shoots.',
            ],
            'miliboo-tripod' => [
                'description' => 'Miliboo tripod systems are commonly selected for video stability, fluid movement, and practical height/load ranges for mirrorless to cinema-light rigs. They are built to support repeatable pans and tilts while keeping setup and balancing approachable for small crews.' . "\n\n" .
                    'As a rental support option, it is ideal for interviews, worship coverage, and conference stages where locked-off reliability and smooth reframing are both needed. It helps deliver cleaner footage without overcomplicating camera ops.',
                'excerpt' => 'Video tripod system for stable framing and smoother pans/tilts in interview, event, and stage productions.',
            ],
            'monopod' => [
                'description' => 'A monopod provides single-point support that reduces operator fatigue while preserving mobility in crowded or fast-changing environments. It is especially useful for event aisles, processions, and documentary movement where tripods are too slow or intrusive.' . "\n\n" .
                    'Rental clients choose monopods when they need steadier footage than handheld but faster repositioning than tripod legs allow. It is a practical middle ground for dynamic coverage and compact travel kits.',
                'excerpt' => 'Mobile camera support that improves handheld stability while allowing quick repositioning in fast-paced shoots.',
            ],
            'mount-adapter-ef-eos-r' => [
                'description' => 'Canon Mount Adapter EF-EOS R enables EF and EF-S lenses on EOS R bodies with full electronic communication for autofocus, stabilization, and metadata transfer. Canon materials also emphasize dust/moisture-resistant construction and metal mount interfaces.' . "\n\n" .
                    'For rentals, this adapter protects prior lens investments and speeds migration to RF camera bodies without replacing entire lens kits. It is essential for teams mixing legacy EF glass with newer mirrorless workflows.',
                'excerpt' => 'Canon EF-EOS R adapter preserving AF, IS, and metadata when using EF/EF-S lenses on EOS R cameras.',
            ],
            'discover-the-versatility-of-the-s1-bracket' => [
                'description' => 'The S1-style bracket is a Bowens-mount speedlight holder designed to convert compact flashes into modifier-ready light sources. It allows quick mounting of softboxes and reflectors without stressing the flash shoe, making small lights more studio-capable.' . "\n\n" .
                    'In rental environments, this bracket is valuable for budget-friendly lighting builds and fast location setups. It helps creators scale from on-camera flash to controlled off-camera key and fill using familiar accessory ecosystems.',
                'excerpt' => 'S1 bracket converts speedlights for Bowens modifier use, enabling faster off-camera lighting control on location.',
            ],
            's2-bracket' => [
                'description' => 'The S2 bracket improves on legacy speedlight holders with stronger grip geometry and easier flash insertion/removal, while retaining Bowens accessory compatibility. It supports bare flash heads or small battery strobes in compact modifier setups.' . "\n\n" .
                    'For rental users, S2 is a practical bridge between portable flashes and larger soft-light tools. It delivers cleaner rigging, quicker changes, and a more stable modifier connection during repeated setup cycles.',
                'excerpt' => 'Improved Bowens-compatible speedlight bracket for faster setup, stronger grip, and flexible modifier workflows.',
            ],
            'sigma-mc-11-mount-converter' => [
                'description' => 'Sigma MC-11 mount converter adapts Canon EF-mount Sigma lenses to Sony E-mount bodies with electronic communication for aperture control, AF behavior, and EXIF transfer on supported lenses. Sigma positions it for optimized use with compatible Global Vision optics.' . "\n\n" .
                    'In rental scenarios, MC-11 is useful for teams leveraging existing EF lens inventories while shooting on Sony mirrorless bodies. It helps expand lens options quickly, though performance is best when matched to officially supported lens lists.',
                'excerpt' => 'EF-to-Sony E electronic adapter for compatible Sigma lenses, preserving aperture control and metadata workflows.',
            ],
            'silver-stand' => [
                'description' => 'A silver light stand offers stable vertical support for heads, modifiers, and small accessories in studio or location lighting. The finish is commonly associated with durable metal construction designed for frequent transport and setup cycles.' . "\n\n" .
                    'For rentals, it is the essential backbone of everyday lighting deployment. Whether used for key, fill, backlight, or practicals, it keeps fixtures safely positioned and simplifies repeatable placement from scene to scene.',
                'excerpt' => 'Durable light stand for secure fixture support in studio and on-location lighting setups.',
            ],
            'enhance-your-recording-experience-with-sony-camcorders-battery' => [
                'description' => 'This Sony camcorder battery category is intended for extended video capture where uninterrupted runtime is critical. Typical pro-compatible packs emphasize stable voltage delivery and predictable discharge for long-form recording sessions.' . "\n\n" .
                    'As a rental spare, it helps camera operators maintain continuous coverage through ceremonies, conferences, and stage performances. Keeping an additional battery on hand reduces missed moments during unavoidable power transitions.',
                'excerpt' => 'Sony camcorder battery option for longer continuous recording and reduced downtime during live events.',
            ],
            'v860ii-speedlight' => [
                'description' => 'Godox V860II is a TTL-capable Li-ion speedlight with guide number 60 (ISO 100, 200mm), fast recycle around 1.5s, and roughly 650 full-power flashes per charge in typical manufacturer documentation. It also supports HSS and wireless operation in the Godox X ecosystem.' . "\n\n" .
                    'For rentals, V860II is a reliable event flash that balances power, speed, and battery efficiency better than many AA-driven units. It is well suited for weddings, portraits, and indoor coverage requiring consistent repeat output.',
                'excerpt' => 'Li-ion TTL speedlight with GN60 output, fast recycle, and high flash count for event and portrait reliability.',
            ],
            'weifeng-tripod' => [
                'description' => 'Weifeng tripods are commonly used as practical video supports with fluid-head style operation and straightforward setup. They are favored in entry-to-mid production kits for stable framing, smoother pans, and predictable locking under modest camera loads.' . "\n\n" .
                    'In rental use, this tripod class is effective for church media teams, interviews, and conference recordings that need dependable support without premium-system complexity. It offers strong value for recurring weekly production work.',
                'excerpt' => 'Practical fluid-head tripod support for stable interview and event coverage with user-friendly deployment.',
            ],
            'zgcine-zg-v99-v160-v-mount-battery' => [
                'description' => 'ZGcine ZG-V99 and V160 batteries are V-mount power solutions designed for cinema cameras, lights, and accessories requiring higher-capacity DC delivery. The lineup targets mobile production with onboard output options and capacity tiers suited to different runtime demands.' . "\n\n" .
                    'For rentals, these packs enable cleaner all-day builds on cameras, monitors, and wireless systems without constant swaps. They are especially useful in location shooting where centralized, high-density power simplifies cable management.',
                'excerpt' => 'V-mount battery options for higher-capacity camera and lighting power in mobile professional production rigs.',
            ],
            'epson-projector' => [
                'description' => 'This Epson projector profile aligns with common rental-class 3LCD XGA units around 3600 lumens, designed for clear text and presentation visuals in lit rooms. Typical specs include HDMI connectivity, 4:3 native aspect behavior, and integrated speaker convenience.' . "\n\n" .
                    'In rental contexts, it is a dependable projector for church announcements, classrooms, seminars, and community events. It is optimized for legibility and setup simplicity rather than cinema-grade contrast, which is ideal for presentation-first use.',
                'excerpt' => 'Bright 3LCD Epson presentation projector class for clear slides, announcements, and event visuals in lit spaces.',
            ],
            'tripod-projector-screen' => [
                'description' => 'A tripod projector screen in this class typically uses matte white material, around 1.1 gain, and a portable stand with adjustable height lock. Common 100-inch 4:3 configurations provide broad compatibility with standard-throw projectors used in venues and classrooms.' . "\n\n" .
                    'For rentals, it is the fastest way to create a clean viewing surface without wall mounting. The foldable transport design and quick deploy mechanism make it ideal for pop-up presentations, ministry events, and mobile training sessions.',
                'excerpt' => 'Portable tripod projector screen with matte white 1.1 gain surface for quick setup in events and presentations.',
            ],
        ];
    }
}
