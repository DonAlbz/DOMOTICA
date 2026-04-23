<?php
// WiredSpace S.r.l. — index.php | Progetto GPOI 2024/2025
require_once 'php/config.php';
$db = getDB();

$servizi = $db->query("SELECT * FROM servizi WHERE attivo=1 ORDER BY ordine")->fetchAll();
$stats   = $db->query("
    SELECT (SELECT COUNT(*) FROM progetti WHERE stato='completato') AS n_proj,
           (SELECT COUNT(*) FROM utenti  WHERE ruolo='cliente')     AS n_cli,
           (SELECT COALESCE(SUM(ore_lavoro),0) FROM interventi)     AS n_ore
")->fetch();
$proj3 = $db->query("
    SELECT p.*, s.nome AS sn, s.icona AS si,
           u.azienda, u.nome AS cn, u.cognome AS cc
    FROM progetti p
    JOIN servizi s ON p.servizio_id=s.id
    JOIN utenti  u ON p.cliente_id=u.id
    WHERE p.stato='completato'
    ORDER BY p.data_fine DESC LIMIT 3
")->fetchAll();

$simgs=[1=>'https://images.unsplash.com/photo-1558618666-fcd25c85cd64?w=600&q=80',
        2=>'https://images.unsplash.com/photo-1557804506-669a67965ba0?w=600&q=80',
        3=>'https://images.unsplash.com/photo-1473341304170-971dccb5ac1e?w=600&q=80',
        4=>'https://images.unsplash.com/photo-1545454675-3531b543be5d?w=600&q=80',
        5=>'https://images.unsplash.com/photo-1544197150-b99a580bb7a8?w=600&q=80',
        6=>'https://images.unsplash.com/photo-1581092160562-40aa08e78837?w=600&q=80'];
$pimgs=['https://images.unsplash.com/photo-1497366216548-37526070297c?w=600&q=80',
        'https://images.unsplash.com/photo-1486406146926-c627a92ad1ab?w=600&q=80',
        'https://images.unsplash.com/photo-1565514020179-026b92b84bb6?w=600&q=80'];

$features=[
  ['&#9889;','Progettazione KNX certificata',
   'I nostri tecnici sono certificatori KNX Partner. Ogni impianto rispetta gli standard europei pi&ugrave; rigorosi, garantendo interoperabilit&agrave; totale e durata nel tempo.'],
  ['&#127807;','Risparmio energetico documentato',
   'I nostri sistemi IoT riducono i consumi fino al 40%, con dashboard real-time, report mensili e ROI calcolato e verificabile da contratto.'],
  ['&#128737;','Sicurezza integrata H24',
   'Videosorveglianza IP, antintrusione e controllo accessi su un&rsquo;unica piattaforma cloud. Accessibile da smartphone ovunque nel mondo.'],
  ['&#127911;','Assistenza post-vendita garantita',
   'Contratti di manutenzione periodica e supporto tecnico remoto 7 giorni su 7. Restiamo al tuo fianco anche dopo l&rsquo;installazione.'],
];
$kpis=[['Soddisfazione clienti',96],['Progetti nei tempi',94],['Efficienza energetica media',87],['Riduzione costi operativi',78]];
$steps=[
  ['01','&#128269;','Sopralluogo gratuito','Analisi tecnica dell&#39;immobile, rilievo planimetrico e definizione delle esigenze. Nessun costo, nessun impegno.'],
  ['02','&#128208;','Progettazione','Schema KNX personalizzato, selezione dei componenti certificati e preventivo dettagliato con tempi e costi trasparenti.'],
  ['03','&#128295;','Installazione','Posa impianto con materiali di prima scelta, cablaggio strutturato e configurazione completa di tutti i sistemi.'],
  ['04','&#10003;','Collaudo','Test funzionale completo, documentazione tecnica e formazione del personale all&#39;utilizzo quotidiano.'],
  ['05','&#127911;','Assistenza','Supporto remoto H24, manutenzione periodica e aggiornamenti software inclusi nel contratto.'],
];
$ora = date('H:i');
$nP  = max((int)$stats['n_proj'],12);
$nC  = max((int)$stats['n_cli'],8);
?>
<!DOCTYPE html>
<html lang="it">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width,initial-scale=1.0">
  <meta name="description" content="WiredSpace progetta e installa impianti domotici KNX per uffici, aziende ed edifici pubblici nel Nord Italia. Sicurezza, efficienza energetica, reti avanzate.">
  <title>WiredSpace S.r.l. &mdash; Smart Building &amp; Domotica Professionale | Nord Italia</title>
  <link rel="stylesheet" href="css/style.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css">
</head>
<body>

<?php include 'php/navbar.php'; ?>

<!-- ═══════════════════════════════════════════════
     HERO
═══════════════════════════════════════════════ -->
<section class="hero" id="hero">
  <div class="hero-grid"></div>
  <div class="orb orb-a"></div>
  <div class="orb orb-b"></div>
  <div class="orb orb-c"></div>
  <canvas id="heroCanvas"></canvas>

  <div class="wrap">
    <div class="hero-wrap">

      <!-- Colonna sinistra -->
      <div class="animate__animated animate__fadeInLeft">

        <div class="hero-badge">
          <span class="badge-pulse"></span>
          Soluzioni intelligenti per il futuro degli edifici
        </div>

        <h1 class="hero-h1">
          <span class="gt">Progettiamo</span><br>
          <span class="gt">l&#39;intelligenza</span><br>
          <span class="sub">di domani.</span>
        </h1>

        <p class="hero-p">
          WiredSpace S.r.l. &egrave; il partner tecnologico di riferimento per
          aziende ed edifici pubblici nel Nord Italia. Progettiamo e installiamo
          impianti domotici che riducono i costi energetici fino al
          <strong>40%</strong> e aumentano sicurezza e produttivit&agrave;.<br><br>
          Specialisti in: <strong><span class="hero-typing">impianti KNX avanzati.</span></strong>
        </p>

        <div class="hero-btns">
          <a href="preventivo.php" class="btn btn-p animate__animated animate__fadeInUp" style="animation-delay:.3s">
            Richiedi preventivo gratuito
          </a>
          <a href="servizi.php" class="btn btn-g animate__animated animate__fadeInUp" style="animation-delay:.45s">
            Scopri i servizi
          </a>
        </div>

        <div class="hero-trust animate__animated animate__fadeIn" style="animation-delay:.65s">
          <div class="trust-i"><span class="trust-ic">&#9889;</span> KNX Partner Certified</div>
          <div class="trust-div"></div>
          <div class="trust-i"><span class="trust-ic">&#128737;</span> ISO 9001:2015</div>
          <div class="trust-div"></div>
          <div class="trust-i"><span class="trust-ic">&#10003;</span> 15 anni</div>
        </div>

      </div>

      <!-- Colonna destra: SmartOffice Dashboard -->
      <div class="hero-right animate__animated animate__fadeInRight" style="animation-delay:.2s">
        <div style="position:relative;max-width:430px;margin-left:auto">

          <div class="mockup" id="smartDash">

            <!-- Barra macOS + orologio -->
            <div class="mock-win">
              <div class="mdot mdot-r"></div>
              <div class="mdot mdot-y"></div>
              <div class="mdot mdot-g"></div>
              <span class="mock-win-ttl">WiredSpace &mdash; SmartOffice Pro</span>
              <span class="mock-win-time" id="dClock"><?php echo $ora; ?></span>
            </div>

            <!-- Stato sistema -->
            <div class="mock-status">
              <div class="ms-l">
                <span class="ms-pulse"></span>
                Sistema attivo &mdash; 12 dispositivi online
              </div>
              <div class="ms-r">Uptime: 99,98%</div>
            </div>

            <!-- Tab switcher -->
            <div class="d-tabs">
              <button class="d-tab on" onclick="dTab(this,'ctrl')">Controllo</button>
              <button class="d-tab" onclick="dTab(this,'energy')">Energia</button>
              <button class="d-tab" onclick="dTab(this,'sec')">Sicurezza</button>
            </div>

            <!-- ── PANNELLO CONTROLLO ── -->
            <div class="d-panel on" id="dp-ctrl">

              <!-- Illuminazione -->
              <div class="drow" id="ddev-luce" onclick="dModal('luce')">
                <div class="dl">
                  <div class="dice" style="background:rgba(251,191,36,.15);border-color:rgba(251,191,36,.3)">
                    <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="#fbbf24" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M9 18h6M10 22h4M12 2a7 7 0 0 1 7 7c0 2.38-1.19 4.47-3 5.74V17a1 1 0 0 1-1 1H9a1 1 0 0 1-1-1v-2.26C6.19 13.47 5 11.38 5 9a7 7 0 0 1 7-7z"/></svg>
                  </div>
                  <div><span class="dn">Illuminazione</span><span class="ds" id="dsub-luce">8 zone attive &mdash; 75%</span></div>
                </div>
                <div class="dr" onclick="event.stopPropagation()">
                  <span class="dv" id="dval-luce" style="color:#fbbf24">75%</span>
                  <button class="tog on" id="dtog-luce" onclick="dToggle('luce',this)" aria-label="Illuminazione"><div class="togk"></div></button>
                </div>
              </div>
              <div class="slrow">
                <svg width="10" height="10" viewBox="0 0 24 24" fill="none" stroke="rgba(221,228,240,.4)" stroke-width="2"><circle cx="12" cy="12" r="4"/><path d="M12 2v2M12 20v2M4.93 4.93l1.41 1.41M17.66 17.66l1.41 1.41M2 12h2M20 12h2M6.34 17.66l-1.41 1.41M19.07 4.93l-1.41 1.41"/></svg>
                <input type="range" class="slider sl-blue" id="dsl-luce" min="0" max="100" value="75" step="1" oninput="dUpdateLuce(this.value)" aria-label="Luminosita">
                <span class="slv" id="dslv-luce">75%</span>
              </div>

              <!-- Clima -->
              <div class="drow" id="ddev-clima" onclick="dModal('clima')">
                <div class="dl">
                  <div class="dice" style="background:rgba(249,115,22,.15);border-color:rgba(249,115,22,.3)">
                    <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="#f97316" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M14 14.76V3.5a2.5 2.5 0 0 0-5 0v11.26a4.5 4.5 0 1 0 5 0z"/></svg>
                  </div>
                  <div><span class="dn">Clima</span><span class="ds" id="dsub-clima">Target: <span id="dtDisp">22</span>&deg;C &mdash; Reale: 21&deg;C</span></div>
                </div>
                <div class="dr" onclick="event.stopPropagation()">
                  <span class="dv" id="dval-clima" style="color:#f97316">22&deg;C</span>
                  <button class="tog on" id="dtog-clima" onclick="dToggle('clima',this)" style="background:linear-gradient(135deg,#f97316,#ef4444)" aria-label="Clima"><div class="togk"></div></button>
                </div>
              </div>
              <div class="slrow">
                <svg width="10" height="10" viewBox="0 0 24 24" fill="none" stroke="#f97316" stroke-width="2.5"><path d="M14 14.76V3.5a2.5 2.5 0 0 0-5 0v11.26a4.5 4.5 0 1 0 5 0z"/></svg>
                <input type="range" class="slider sl-warm" id="dsl-temp" min="16" max="30" value="22" step="1" oninput="dUpdateTemp(this.value)" aria-label="Temperatura">
                <span class="slv" id="dslv-temp" style="color:#f97316">22&deg;C</span>
              </div>

              <!-- Ventilazione -->
              <div class="drow" id="ddev-vent" onclick="dModal('vent')">
                <div class="dl">
                  <div class="dice" style="background:rgba(56,214,245,.12);border-color:rgba(56,214,245,.28)">
                    <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="#38d6f5" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M9.59 4.59A2 2 0 1 1 11 8H2m10.59 11.41A2 2 0 1 0 14 16H2m15.73-8.27A2.5 2.5 0 1 1 19.5 12H2"/></svg>
                  </div>
                  <div><span class="dn">Ventilazione</span><span class="ds" id="dsub-vent">Velocit&agrave;: <span id="dvDisp">60</span>% &mdash; CO&#8322; OK</span></div>
                </div>
                <div class="dr" onclick="event.stopPropagation()">
                  <span class="dv" id="dval-vent" style="color:#38d6f5">60%</span>
                  <button class="tog on" id="dtog-vent" onclick="dToggle('vent',this)" style="background:linear-gradient(135deg,#38d6f5,#2360ff)" aria-label="Ventilazione"><div class="togk"></div></button>
                </div>
              </div>
              <div class="slrow">
                <svg width="10" height="10" viewBox="0 0 24 24" fill="none" stroke="#38d6f5" stroke-width="2"><path d="M9.59 4.59A2 2 0 1 1 11 8H2m10.59 11.41A2 2 0 1 0 14 16H2m15.73-8.27A2.5 2.5 0 1 1 19.5 12H2"/></svg>
                <input type="range" class="slider sl-blue" id="dsl-vent" min="0" max="100" value="60" step="1" oninput="dUpdateVent(this.value)" aria-label="Ventilazione">
                <span class="slv" id="dslv-vent">60%</span>
              </div>

              <!-- Sicurezza -->
              <div class="drow" id="ddev-sic" onclick="dModal('sic')">
                <div class="dl">
                  <div class="dice" style="background:rgba(34,197,94,.12);border-color:rgba(34,197,94,.28)">
                    <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="#22c55e" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"/></svg>
                  </div>
                  <div><span class="dn">Sicurezza</span><span class="ds">6 sensori attivi &mdash; nessuna anomalia</span></div>
                </div>
                <div class="dr" onclick="event.stopPropagation()">
                  <span class="dv" id="dval-sic" style="color:#22c55e">OK</span>
                  <button class="tog on" id="dtog-sic" onclick="dToggle('sic',this)" style="background:linear-gradient(135deg,#16a34a,#22c55e)" aria-label="Sicurezza"><div class="togk"></div></button>
                </div>
              </div>

            </div><!-- /dp-ctrl -->

            <!-- ── PANNELLO ENERGIA ── -->
            <div class="d-panel" id="dp-energy">
              <div class="e-kpis">
                <div class="ekpi"><span class="ekpi-v" style="color:#22c55e">-38%</span><span class="ekpi-l">Risparmio</span></div>
                <div class="ekpi"><span class="ekpi-v" id="dkw" style="color:#00d4bc">2.4 kW</span><span class="ekpi-l">Ora</span></div>
                <div class="ekpi"><span class="ekpi-v" style="color:#f59e0b">34 kWh</span><span class="ekpi-l">Oggi</span></div>
              </div>
              <div class="e-chart">
                <div class="e-ch-h">
                  <span class="e-ch-t">Consumi giornalieri &mdash; kWh</span>
                  <span class="e-ch-b">-38% vs media</span>
                </div>
                <div class="e-bars" id="dBars">
                  <div class="e-bar" data-h="68"></div>
                  <div class="e-bar" data-h="75"></div>
                  <div class="e-bar" data-h="52"></div>
                  <div class="e-bar" data-h="88"></div>
                  <div class="e-bar" data-h="43"></div>
                  <div class="e-bar" data-h="61"></div>
                  <div class="e-bar" data-h="79"></div>
                  <div class="e-bar today" data-h="34"></div>
                </div>
                <div class="e-lbls">
                  <span>Lun</span><span>Mar</span><span>Mer</span><span>Gio</span>
                  <span>Ven</span><span>Sab</span><span>Dom</span><span class="now">Oggi</span>
                </div>
              </div>
              <div class="e-footer">
                <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="#22c55e" stroke-width="2.5"><polyline points="23 6 13.5 15.5 8.5 10.5 1 18"/><polyline points="17 6 23 6 23 12"/></svg>
                Risparmio mensile: <strong style="color:#86efac">&euro;&nbsp;2.340</strong>
                <span style="margin-left:auto;font-size:.6rem;color:rgba(221,228,240,.35)">Fonte: contatore smart</span>
              </div>
            </div><!-- /dp-energy -->

            <!-- ── PANNELLO SICUREZZA ── -->
            <div class="d-panel" id="dp-sec">
              <div class="sec-list">
                <div class="sec-ok"><svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><polyline points="20 6 9 17 4 12"/></svg> Telecamere IP &mdash; 4/4 online</div>
                <div class="sec-ok"><svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><polyline points="20 6 9 17 4 12"/></svg> Sensori PIR &mdash; 6/6 attivi</div>
                <div class="sec-ok"><svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><polyline points="20 6 9 17 4 12"/></svg> Controllo accessi &mdash; badge NFC</div>
                <div class="sec-ok"><svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><polyline points="20 6 9 17 4 12"/></svg> Rilevatori fumo &mdash; test OK</div>
                <div class="sec-warn"><svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><path d="M10.29 3.86L1.82 18a2 2 0 0 0 1.71 3h16.94a2 2 0 0 0 1.71-3L13.71 3.86a2 2 0 0 0-3.42 0z"/><line x1="12" y1="9" x2="12" y2="13"/></svg> Finestra sala riunioni &mdash; aperta</div>
              </div>
              <div class="sec-alarm" id="dAlarmRow">
                <span><svg width="11" height="11" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" style="vertical-align:middle;margin-right:3px"><path d="M18 8A6 6 0 0 0 6 8c0 7-3 9-3 9h18s-3-2-3-9"/><path d="M13.73 21a2 2 0 0 1-3.46 0"/></svg>Allarme: <strong id="dAlarmTxt">DISATTIVATO</strong></span>
                <div class="sec-btns">
                  <button class="sb sb-arm" id="dBtnArm" onclick="dSetAlarm(true)">Arma</button>
                  <button class="sb sb-dis" id="dBtnDis" onclick="dSetAlarm(false)" style="display:none">Disarma</button>
                </div>
              </div>
            </div><!-- /dp-sec -->

          </div><!-- /mockup -->

          <!-- Pill 1 -->
          <div class="pill pill-1">
            <div class="pill-ico pill-bl">
              <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="#2360ff" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><path d="M18 8A6 6 0 0 0 6 8c0 7-3 9-3 9h18s-3-2-3-9"/><path d="M13.73 21a2 2 0 0 1-3.46 0"/></svg>
            </div>
            <div>
              <span class="pill-sm">Risparmio mensile certificato</span>
              <strong>&euro;&nbsp;2.340 risparmiati</strong>
            </div>
          </div>

          <!-- Pill 2 -->
          <div class="pill pill-2">
            <div class="pill-ico pill-tl">
              <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="#00d4bc" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><line x1="18" y1="20" x2="18" y2="10"/><line x1="12" y1="20" x2="12" y2="4"/><line x1="6" y1="20" x2="6" y2="14"/></svg>
            </div>
            <div>
              <span class="pill-sm">Uptime sistema</span>
              <strong>99,98% affidabilit&agrave;</strong>
            </div>
          </div>

          <!-- Modal overlay -->
          <div id="dModal" class="modal-ov" onclick="if(event.target===this)dCloseModal()">
            <div class="modal-box" id="dModalBox"></div>
          </div>

        </div>
      </div><!-- /hero-right -->

    </div><!-- /hero-wrap -->
  </div>

  <div class="scroll-h" onclick="document.getElementById('mq').scrollIntoView({behavior:'smooth'})">
    Scopri <div class="scroll-l"></div>
  </div>
</section>


<!-- ═══════════════════════════════════════════════
     MARQUEE
═══════════════════════════════════════════════ -->
<div class="marquee" id="mq">
  <div class="mq-t">
    <?php
    $mq=['KNX Partner Certified','ISO 9001:2015','15 anni di esperienza','100+ progetti completati','Brescia &middot; Milano &middot; Bergamo','Domotica KNX','Videosorveglianza IP','Efficienza Energetica','Wi-Fi 6 Enterprise','Audio Multiroom','Building Automation','EPBD 2024'];
    $mq=array_merge($mq,$mq);
    foreach($mq as $m) echo '<span class="mq-i"><span class="mq-dot"></span><strong>'.$m.'</strong></span>';
    ?>
  </div>
</div>


<!-- ═══════════════════════════════════════════════
     SERVIZI
═══════════════════════════════════════════════ -->
<section class="section" id="servizi">
  <div class="wrap">
    <div style="display:flex;justify-content:space-between;align-items:flex-end;margin-bottom:4.5rem;flex-wrap:wrap;gap:1.5rem">
      <div>
        <div class="eyebrow">Cosa facciamo</div>
        <h2 class="s-h2">Soluzioni <span class="gt">su misura</span><br>per ogni edificio</h2>
      </div>
      <div style="max-width:360px">
        <p class="s-p">Dalla piccola azienda al grande edificio pubblico, ogni progetto nasce da una consulenza tecnica approfondita.</p>
        <a href="servizi.php" class="btn btn-g" style="margin-top:1.25rem">Tutti i servizi &rarr;</a>
      </div>
    </div>
    <div class="servizi-g">
      <?php foreach($servizi as $i=>$s): ?>
      <article class="sc reveal" style="transition-delay:<?php echo $i*.08; ?>s">
        <div class="sc-img">
          <img src="<?php echo $simgs[$s['id']]??''; ?>" alt="<?php echo esc($s['nome']); ?>" loading="lazy">
          <div class="sc-fade"></div>
          <span class="sc-num">0<?php echo $i+1; ?></span>
        </div>
        <div class="sc-body">
          <div class="sc-ico"><?php echo $s['icona']; ?></div>
          <h3><?php echo esc($s['nome']); ?></h3>
          <p><?php echo esc(mb_substr($s['descrizione'],0,100)); ?>&hellip;</p>
          <a href="servizi.php?id=<?php echo $s['id']; ?>" class="sc-link">Scopri di pi&ugrave;</a>
        </div>
      </article>
      <?php endforeach; ?>
    </div>
  </div>
</section>


<!-- ═══════════════════════════════════════════════
     PERCHE' SCEGLIERCI
═══════════════════════════════════════════════ -->
<section class="section-alt">
  <div class="wrap">
    <div class="feat-g">

      <div class="rl">
        <div class="eyebrow">Perch&eacute; sceglierci</div>
        <h2 class="s-h2" style="margin-bottom:1.75rem">
          Non installiamo impianti.<br>
          <span class="gt2">Costruiamo futuro.</span>
        </h2>
        <p class="s-p" style="margin-bottom:2.75rem">Ogni progetto WiredSpace nasce da un&#39;analisi approfondita degli spazi e delle esigenze del cliente. Il risultato &egrave; un ecosistema tecnologico integrato, efficiente e scalabile nel tempo.</p>
        <div class="feat-list">
          <?php foreach($features as $f): ?>
          <div class="feat-i reveal">
            <div class="feat-ico"><?php echo $f[0]; ?></div>
            <div class="feat-t"><h3><?php echo $f[1]; ?></h3><p><?php echo $f[2]; ?></p></div>
          </div>
          <?php endforeach; ?>
        </div>
      </div>

      <div class="rr">
        <div class="kpi-panel">
          <div class="kpi-row">
            <div class="kpi"><span class="kpi-v">-40%</span><span class="kpi-l">Costi energetici</span></div>
            <div class="kpi"><span class="kpi-v">+35%</span><span class="kpi-l">Produttivit&agrave;</span></div>
            <div class="kpi"><span class="kpi-v">99,9%</span><span class="kpi-l">Uptime</span></div>
          </div>
          <div class="prog-l">
            <?php foreach($kpis as $k): ?>
            <div>
              <div class="prog-h"><span class="prog-lbl"><?php echo $k[0]; ?></span><span class="prog-val"><?php echo $k[1]; ?>%</span></div>
              <div class="prog-bar"><div class="prog-fill" data-w="<?php echo $k[1]; ?>"></div></div>
            </div>
            <?php endforeach; ?>
          </div>
        </div>
      </div>

    </div>
  </div>
</section>


<!-- ═══════════════════════════════════════════════
     STATISTICHE
═══════════════════════════════════════════════ -->
<section class="section-sm">
  <div class="wrap">
    <div class="stats-box rs">
      <h2 class="s-h2 tc" style="margin-bottom:.75rem">I numeri di <span class="gt">WiredSpace</span></h2>
      <p style="text-align:center;color:var(--muted);font-size:.88rem;margin-bottom:3rem;font-weight:300">Dati verificati dai nostri clienti nel Nord Italia</p>
      <div class="stats-g">
        <div class="tc"><span class="stat-n" data-count="<?php echo $nP; ?>" data-suffix="+">0+</span><p class="stat-l">Progetti completati</p></div>
        <div class="tc"><span class="stat-n" data-count="<?php echo $nC; ?>" data-suffix="+">0+</span><p class="stat-l">Clienti nel Nord Italia</p></div>
        <div class="tc"><span class="stat-n" data-count="40" data-suffix="%">0%</span><p class="stat-l">Risparmio energetico medio</p></div>
        <div class="tc"><span class="stat-n" data-count="15">0</span><p class="stat-l">Anni di esperienza</p></div>
      </div>
    </div>
  </div>
</section>


<!-- ═══════════════════════════════════════════════
     PROCESSO
═══════════════════════════════════════════════ -->
<section class="section tc">
  <div class="wrap">
    <div class="eyebrow ec">Il nostro metodo</div>
    <h2 class="s-h2" style="margin-bottom:.875rem">
      Dal sopralluogo al collaudo,<br><span class="gt">ogni passo &egrave; curato.</span>
    </h2>
    <p class="s-p" style="margin:0 auto 5.5rem">Un processo collaudato in 15 anni di progetti. Nessuna sorpresa, nessun ritardo, nessun costo nascosto.</p>
    <div class="proc-w">
      <div class="proc-ln"></div>
      <div class="proc-g">
        <?php foreach($steps as $si=>$st): ?>
        <div class="pstep reveal" style="transition-delay:<?php echo $si*.1; ?>s">
          <div class="pnum"><?php echo $st[0]; ?></div>
          <div class="pico"><?php echo $st[1]; ?></div>
          <h3><?php echo $st[2]; ?></h3>
          <p><?php echo $st[3]; ?></p>
        </div>
        <?php endforeach; ?>
      </div>
    </div>
  </div>
</section>


<!-- ═══════════════════════════════════════════════
     PORTFOLIO
═══════════════════════════════════════════════ -->
<?php if($proj3): ?>
<section class="section-alt">
  <div class="wrap">
    <div style="display:flex;justify-content:space-between;align-items:flex-end;margin-bottom:4rem;flex-wrap:wrap;gap:1rem">
      <div>
        <div class="eyebrow">Portfolio</div>
        <h2 class="s-h2">Risultati concreti<br><span class="gt">per i nostri clienti.</span></h2>
      </div>
      <a href="progetti.php" class="btn btn-g">Vedi tutti &rarr;</a>
    </div>
    <div class="proj-g">
      <?php foreach($proj3 as $pi=>$pr): ?>
      <article class="proj reveal" style="transition-delay:<?php echo $pi*.1; ?>s">
        <div class="proj-img">
          <img src="<?php echo $pimgs[$pi]??$pimgs[0]; ?>" alt="<?php echo esc($pr['titolo']); ?>" loading="lazy">
          <div class="proj-ov"></div>
          <span class="badge badge-green proj-st">&#10003; Completato</span>
        </div>
        <div class="proj-body">
          <h3><?php echo esc($pr['titolo']); ?></h3>
          <p class="proj-cli">&#127970; <?php echo esc($pr['azienda']??$pr['cn'].' '.$pr['cc']); ?></p>
          <div class="proj-tags">
            <span class="ptag"><?php echo esc($pr['sn']); ?></span>
            <?php if($pr['indirizzo']): ?><span class="ptag">&#128205; <?php echo esc(explode(',',$pr['indirizzo'])[0]); ?></span><?php endif; ?>
            <?php if($pr['budget']): ?><span class="ptag">&euro; <?php echo number_format($pr['budget'],0,',','.'); ?></span><?php endif; ?>
          </div>
          <?php if($pr['descrizione']): ?><p class="proj-desc"><?php echo esc(mb_substr($pr['descrizione'],0,110)); ?>&hellip;</p><?php endif; ?>
        </div>
      </article>
      <?php endforeach; ?>
    </div>
  </div>
</section>
<?php endif; ?>


<!-- ═══════════════════════════════════════════════
     CTA FINALE
═══════════════════════════════════════════════ -->
<section class="section">
  <div class="wrap">
    <div class="cta-box rs">
      <div class="eyebrow ec" style="opacity:.65">Inizia oggi</div>
      <h2 class="s-h2" style="margin-bottom:1.125rem">
        Trasforma il tuo edificio<br><span class="gt">in un asset tecnologico.</span>
      </h2>
      <p class="s-p" style="margin:0 auto 3rem;text-align:center">
        Sopralluogo gratuito, preventivo personalizzato, nessun impegno.<br>
        Ti ricontattiamo entro <strong style="color:var(--teal)">24 ore lavorative</strong>.
      </p>
      <div style="display:flex;gap:1rem;justify-content:center;flex-wrap:wrap;position:relative">
        <a href="preventivo.php" class="btn btn-p" style="font-size:.95rem;padding:1rem 2.25rem">&#128203; Preventivo gratuito</a>
        <a href="tel:+390212345678" class="btn btn-g" style="font-size:.95rem;padding:1rem 2.25rem">&#128222; Chiamaci ora</a>
        <a href="contatti.php" class="btn btn-o" style="font-size:.95rem;padding:1rem 2.25rem">&#9993; Scrivici</a>
      </div>
    </div>
  </div>
</section>


<?php include 'php/footer.php'; ?>
<script src="js/main.js"></script>
</body>
</html>
