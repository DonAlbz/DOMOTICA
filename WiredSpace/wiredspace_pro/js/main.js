'use strict';
/* WiredSpace S.r.l. — main.js v6 DEFINITIVO
   Libreria esterna: Animate.css 4.1.1 (CDN cdnjs.cloudflare.com)
   Progetto GPOI | Anno Scolastico 2024/2025 */

/* ── 1. HAMBURGER ── */
function toggleMenu(){
  var n=document.querySelector('.nb-menu'),b=document.querySelector('.ham');
  n.classList.toggle('open');
  var s=b.querySelectorAll('span'),o=n.classList.contains('open');
  if(s[0])s[0].style.transform=o?'rotate(45deg) translate(5px,5px)':'';
  if(s[1])s[1].style.opacity=o?'0':'';
  if(s[2])s[2].style.transform=o?'rotate(-45deg) translate(5px,-5px)':'';
}
document.addEventListener('click',function(e){
  var n=document.querySelector('.nb-menu'),b=document.querySelector('.ham');
  if(n&&b&&!n.contains(e.target)&&!b.contains(e.target)){
    n.classList.remove('open');
    var s=b.querySelectorAll('span');
    if(s[0])s[0].style.transform='';
    if(s[1])s[1].style.opacity='';
    if(s[2])s[2].style.transform='';
  }
});

/* ── 2. NAVBAR STICKY ── */
window.addEventListener('scroll',function(){
  var nb=document.querySelector('.navbar');
  if(nb)nb.classList.toggle('stuck',window.scrollY>60);
},{passive:true});

/* ── 3. SCROLL REVEAL ── */
(function(){
  var els=document.querySelectorAll('.reveal,.rl,.rr,.rs');
  if(!els.length)return;
  if(!('IntersectionObserver' in window)){els.forEach(function(e){e.classList.add('on');});return;}
  var io=new IntersectionObserver(function(entries){
    var d=0;
    entries.forEach(function(e){
      if(e.isIntersecting){
        (function(el,delay){setTimeout(function(){el.classList.add('on');},delay);}(e.target,d));
        d+=72; io.unobserve(e.target);
      }
    });
  },{threshold:.1,rootMargin:'0px 0px -45px 0px'});
  els.forEach(function(el){io.observe(el);});
}());

/* ── 4. COUNTER ── */
(function(){
  var els=document.querySelectorAll('[data-count]');
  if(!els.length)return;
  var io=new IntersectionObserver(function(entries){
    entries.forEach(function(entry){
      if(!entry.isIntersecting)return;
      var el=entry.target,target=parseFloat(el.dataset.count),suffix=el.dataset.suffix||'',dur=2400,steps=70,cur=0,f=0,isInt=(target===Math.floor(target));
      var t=setInterval(function(){cur+=target/steps;f++;if(f>=steps){cur=target;clearInterval(t);}el.textContent=(isInt?Math.floor(cur):cur.toFixed(1))+suffix;},dur/steps);
      io.unobserve(el);
    });
  },{threshold:.5});
  els.forEach(function(el){io.observe(el);});
}());

/* ── 5. CANVAS PARTICELLE ── */
(function(){
  var canvas=document.getElementById('heroCanvas');
  if(!canvas)return;
  var ctx=canvas.getContext('2d'),W,H,pts=[],mx=-9999,my=-9999;
  function resize(){W=canvas.width=canvas.offsetWidth;H=canvas.height=canvas.offsetHeight;}
  resize();
  window.addEventListener('resize',function(){resize();build();},{passive:true});
  function build(){
    var N=Math.min(Math.floor((W*H)/9500),105);
    pts=[];
    for(var i=0;i<N;i++)pts.push({x:Math.random()*W,y:Math.random()*H,vx:(Math.random()-.5)*.32,vy:(Math.random()-.5)*.32,r:Math.random()*1.4+.5,ph:Math.random()*Math.PI*2,sp:Math.random()*.018+.008});
  }
  build();
  var hero=document.querySelector('.hero');
  if(hero){
    hero.addEventListener('mousemove',function(e){var r=canvas.getBoundingClientRect();mx=e.clientX-r.left;my=e.clientY-r.top;},{passive:true});
    hero.addEventListener('mouseleave',function(){mx=-9999;my=-9999;});
  }
  function draw(){
    ctx.clearRect(0,0,W,H);
    var i,j,p,dx,dy,d,al,g;
    for(i=0;i<pts.length;i++){
      p=pts[i];p.x+=p.vx;p.y+=p.vy;p.ph+=p.sp;
      if(p.x<0||p.x>W)p.vx*=-1;if(p.y<0||p.y>H)p.vy*=-1;
      dx=mx-p.x;dy=my-p.y;d=Math.sqrt(dx*dx+dy*dy);
      if(d<155){p.vx+=dx*.00022;p.vy+=dy*.00022;}
      ctx.beginPath();ctx.arc(p.x,p.y,p.r*(1+Math.sin(p.ph)*.25),0,Math.PI*2);
      ctx.fillStyle='rgba(0,200,180,'+(0.32+Math.sin(p.ph)*.18)+')';ctx.fill();
    }
    for(i=0;i<pts.length;i++)for(j=i+1;j<pts.length;j++){
      dx=pts[i].x-pts[j].x;dy=pts[i].y-pts[j].y;d=Math.sqrt(dx*dx+dy*dy);
      if(d<120){al=(1-d/120)*.16;g=ctx.createLinearGradient(pts[i].x,pts[i].y,pts[j].x,pts[j].y);g.addColorStop(0,'rgba(35,96,255,'+al+')');g.addColorStop(1,'rgba(0,212,188,'+al+')');ctx.beginPath();ctx.moveTo(pts[i].x,pts[i].y);ctx.lineTo(pts[j].x,pts[j].y);ctx.strokeStyle=g;ctx.lineWidth=.7;ctx.stroke();}
    }
    requestAnimationFrame(draw);
  }
  draw();
}());

/* ── 6. PROGRESS BARS ── */
(function(){
  var fills=document.querySelectorAll('.prog-fill');
  if(!fills.length)return;
  var io=new IntersectionObserver(function(entries){entries.forEach(function(e){if(e.isIntersecting){e.target.style.width=(e.target.dataset.w||0)+'%';io.unobserve(e.target);}});},{threshold:.3});
  fills.forEach(function(f){f.style.width='0%';io.observe(f);});
}());

/* ── 7. TYPING EFFECT ── */
(function(){
  var el=document.querySelector('.hero-typing');
  if(!el)return;
  var words=['impianti KNX avanzati.','domotica professionale.','sicurezza integrata.','efficienza energetica.','edifici intelligenti.'];
  var wi=0,ci=0,del=false;
  function type(){var w=words[wi];if(!del){el.textContent=w.slice(0,++ci);if(ci===w.length){del=true;setTimeout(type,2300);return;}}else{el.textContent=w.slice(0,--ci);if(ci===0){del=false;wi=(wi+1)%words.length;}}setTimeout(type,del?44:72);}
  setTimeout(type,1500);
}());

/* ── 8. SMOOTH SCROLL ── */
document.querySelectorAll('a[href^="#"]').forEach(function(a){
  a.addEventListener('click',function(e){var t=document.querySelector(a.getAttribute('href'));if(t){e.preventDefault();t.scrollIntoView({behavior:'smooth',block:'start'});}});
});

/* ── 9. CURSOR GLOW ── */
(function(){
  if(window.innerWidth<900)return;
  var g=document.createElement('div');
  g.style.cssText='position:fixed;width:400px;height:400px;border-radius:50%;background:radial-gradient(circle,rgba(0,212,188,.04) 0%,transparent 65%);pointer-events:none;z-index:9997;transform:translate(-50%,-50%);transition:left .12s,top .12s;will-change:left,top;';
  document.body.appendChild(g);
  document.addEventListener('mousemove',function(e){g.style.left=e.clientX+'px';g.style.top=e.clientY+'px';},{passive:true});
}());

/* ── 10. TILT 3D ── */
document.querySelectorAll('.sc,.proj,.feat-i').forEach(function(card){
  card.addEventListener('mousemove',function(e){var r=card.getBoundingClientRect(),dx=(e.clientX-r.left-r.width/2)/(r.width/2),dy=(e.clientY-r.top-r.height/2)/(r.height/2);card.style.transform='perspective(900px) rotateY('+(dx*5)+'deg) rotateX('+(-dy*5)+'deg) translateY(-10px)';});
  card.addEventListener('mouseleave',function(){card.style.transform='';});
});

/* ── 11. ALERT DISMISS ── */
document.querySelectorAll('.alert').forEach(function(a){setTimeout(function(){a.style.transition='opacity .5s';a.style.opacity='0';setTimeout(function(){if(a.parentNode)a.parentNode.removeChild(a);},500);},5000);});

/* ── 12. CONFIRM ── */
document.querySelectorAll('[data-confirm]').forEach(function(b){b.addEventListener('click',function(e){if(!confirm(b.getAttribute('data-confirm')||'Sei sicuro?')){e.preventDefault();e.stopPropagation();}});});

/* ── 13. TAB SYSTEM ── */
function showTab(name,btn){
  document.querySelectorAll('.tab-pane').forEach(function(p){p.classList.remove('active');});
  document.querySelectorAll('.tab-btn').forEach(function(b){b.classList.remove('active');});
  var pane=document.getElementById('tab-'+name);if(pane)pane.classList.add('active');
  if(btn)btn.classList.add('active');
}

/* ── 14. DASHBOARD SMARTOFFICE ── */
var DS={luce:{on:true,bri:75},clima:{on:true,temp:22,real:21},vent:{on:true,speed:60},sic:{on:true},alarm:false,kw:2.4};

/* Orologio */
(function(){
  var el=document.getElementById('dClock');
  if(!el)return;
  function t(){var d=new Date();el.textContent=String(d.getHours()).padStart(2,'0')+':'+String(d.getMinutes()).padStart(2,'0')+':'+String(d.getSeconds()).padStart(2,'0');}
  t();setInterval(t,1000);
}());

/* kW simulazione */
setInterval(function(){
  DS.kw=Math.max(1.2,Math.min(4.0,DS.kw+(Math.random()-.5)*.28));
  var el=document.getElementById('dkw');if(el)el.textContent=DS.kw.toFixed(1)+' kW';
},3000);

/* Tabs dashboard */
function dTab(btn,name){
  document.querySelectorAll('.d-tab').forEach(function(t){t.classList.remove('on');});
  document.querySelectorAll('.d-panel').forEach(function(p){p.classList.remove('on');});
  btn.classList.add('on');
  var p=document.getElementById('dp-'+name);if(p)p.classList.add('on');
  if(name==='energy')dAnimBars();
}

/* Grafico barre */
function dAnimBars(){
  document.querySelectorAll('#dBars .e-bar').forEach(function(bar){
    bar.style.height='4px';
    var h=bar.getAttribute('data-h')||'50',idx=Array.prototype.indexOf.call(bar.parentNode.children,bar);
    setTimeout(function(){bar.style.height=h+'%';},55+idx*72);
  });
}
setTimeout(function(){
  var p=document.getElementById('dp-energy');if(p&&p.classList.contains('on'))dAnimBars();
},500);

/* Toggle dispositivo */
function dToggle(id,btn){
  DS[id].on=!DS[id].on;
  DS[id].on?btn.classList.add('on'):btn.classList.remove('on');
  var dev=document.getElementById('ddev-'+id);
  if(dev)DS[id].on?dev.classList.remove('doff'):dev.classList.add('doff');
}

/* Slider luce */
function dUpdateLuce(v){
  v=parseInt(v,10);DS.luce.bri=v;
  var a=document.getElementById('dval-luce'),b=document.getElementById('dslv-luce'),c=document.getElementById('dsub-luce');
  if(a)a.textContent=v+'%';if(b)b.textContent=v+'%';if(c)c.textContent=DS.luce.zones+' zone attive \u2014 '+v+'%';
}

/* Slider temperatura */
function dUpdateTemp(v){
  v=parseInt(v,10);DS.clima.temp=v;
  var a=document.getElementById('dval-clima'),b=document.getElementById('dslv-temp'),c=document.getElementById('dtDisp'),d=document.getElementById('dsub-clima');
  if(a)a.textContent=v+'\u00b0C';if(b)b.textContent=v+'\u00b0C';if(c)c.textContent=v;if(d)d.textContent='Target: '+v+'\u00b0C \u2014 Reale: '+DS.clima.real+'\u00b0C';
}

/* Slider ventilazione */
function dUpdateVent(v){
  v=parseInt(v,10);DS.vent.speed=v;
  var a=document.getElementById('dval-vent'),b=document.getElementById('dslv-vent'),c=document.getElementById('dvDisp'),d=document.getElementById('dsub-vent');
  if(a)a.textContent=v+'%';if(b)b.textContent=v+'%';if(c)c.textContent=v;if(d)d.textContent='Velocit\u00e0: '+v+'% \u2014 CO\u2082 OK';
}

/* Dati modal */
var DM={
  luce:{title:'Illuminazione',col:'#fbbf24',
    svg:'<svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="#fbbf24" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M9 18h6M10 22h4M12 2a7 7 0 0 1 7 7c0 2.38-1.19 4.47-3 5.74V17a1 1 0 0 1-1 1H9a1 1 0 0 1-1-1v-2.26C6.19 13.47 5 11.38 5 9a7 7 0 0 1 7-7z"/></svg>',
    rows:[['Protocollo','KNX TP'],['Zone totali','10'],['Zone attive','8'],['Consumo ora','0.42 kW'],['Consumo oggi','3.8 kWh']],
    sl:{label:'Intensit\u00e0 globale',id:'dsl-luce',fn:'dUpdateLuce',min:0,max:100,unit:'%',cls:'slider sl-blue'}},
  clima:{title:'Clima',col:'#f97316',
    svg:'<svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="#f97316" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M14 14.76V3.5a2.5 2.5 0 0 0-5 0v11.26a4.5 4.5 0 1 0 5 0z"/></svg>',
    rows:[['Temp. reale','21\u00b0C'],['Umidit\u00e0','48%'],['Modalit\u00e0','Riscaldamento'],['CO\u2082','412 ppm'],['Consumo','1.2 kW']],
    sl:{label:'Temperatura target (\u00b0C)',id:'dsl-temp',fn:'dUpdateTemp',min:16,max:30,unit:'\u00b0C',cls:'slider sl-warm'}},
  vent:{title:'Ventilazione',col:'#38d6f5',
    svg:'<svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="#38d6f5" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M9.59 4.59A2 2 0 1 1 11 8H2m10.59 11.41A2 2 0 1 0 14 16H2m15.73-8.27A2.5 2.5 0 1 1 19.5 12H2"/></svg>',
    rows:[['CO\u2082','410 ppm'],['Qualit\u00e0 aria','Ottima'],['Portata','320 m\u00b3/h'],['Filtro','Cambiare tra 45 gg'],['Consumo','0.35 kW']],
    sl:{label:'Velocit\u00e0 ventola',id:'dsl-vent',fn:'dUpdateVent',min:0,max:100,unit:'%',cls:'slider sl-blue'}},
  sic:{title:'Sicurezza',col:'#22c55e',
    svg:'<svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="#22c55e" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"/></svg>',
    rows:[['Telecamere','4/4 online'],['Sensori PIR','6/6 attivi'],['Controllo accessi','Badge NFC'],['Ultimo accesso','08:42 \u2014 M. Rossi'],['Stato allarme','Disattivato']],
    sl:null}
};

function dModal(id){
  var d=DM[id];if(!d)return;
  var slEl=d.sl?document.getElementById(d.sl.id):null,cv=slEl?parseInt(slEl.value,10):50;
  var rows=d.rows.map(function(r){return '<div class="modal-r"><span class="modal-k">'+r[0]+'</span><span class="modal-v">'+r[1]+'</span></div>';}).join('');
  var sl='';
  if(d.sl)sl='<div class="modal-sl"><label>'+d.sl.label+'</label><div style="display:flex;align-items:center;gap:.5rem"><input type="range" class="'+d.sl.cls+'" min="'+d.sl.min+'" max="'+d.sl.max+'" value="'+cv+'" step="1" oninput="'+d.sl.fn+'(this.value);document.getElementById(\'dmslv\').textContent=this.value+\''+d.sl.unit+'\'" style="flex:1"><span id="dmslv" class="modal-slv">'+cv+d.sl.unit+'</span></div></div>';
  document.getElementById('dModalBox').innerHTML='<div class="modal-h">'+d.svg+'&nbsp;'+d.title+'<span class="modal-x" onclick="dCloseModal()">&times;</span></div>'+rows+sl;
  var ov=document.getElementById('dModal');if(ov)ov.classList.add('open');
}
function dCloseModal(){var ov=document.getElementById('dModal');if(ov)ov.classList.remove('open');}
(function(){var ov=document.getElementById('dModal');if(!ov)return;ov.addEventListener('click',function(e){if(e.target===ov)dCloseModal();});})();

/* Allarme */
function dSetAlarm(arm){
  DS.alarm=arm;
  var row=document.getElementById('dAlarmRow'),txt=document.getElementById('dAlarmTxt'),ba=document.getElementById('dBtnArm'),bd=document.getElementById('dBtnDis');
  if(!row||!txt||!ba||!bd)return;
  if(arm){row.classList.add('armed');txt.textContent='ARMATO';ba.style.display='none';bd.style.display='';}
  else{row.classList.remove('armed');txt.textContent='DISATTIVATO';ba.style.display='';bd.style.display='none';}
}
