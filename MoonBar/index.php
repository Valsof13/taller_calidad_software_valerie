<?php session_start(); ?>
<!DOCTYPE html>
<html lang="es">
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width,initial-scale=1">
<title>MoonBar - Inicio</title>
<link rel="stylesheet" href="css/styles.css">

<style>
/* BOTÓN FLOTANTE DE LOGIN */
.login-floating {
  position: fixed;
  top: 12px;
  right: 18px;
  color: #f8f6f6ff;
  padding: 10px 18px;
  border-radius: 8px;
  font-weight: bold;
  text-decoration: none;
  box-shadow: 0 3px 6px rgba(0,0,0,0.25);
  z-index: 9999;
  transition: 0.25s;
}
.login-floating:hover {
  background: #cbaae5ff;
}

/* NAV */
nav {
  background: linear-gradient(90deg,#6B0F0F,#4c0b0b);
  padding: 14px;
  text-align: center;
}
nav a { color:#fff; margin:0 12px; text-decoration:none; font-weight:600; }
nav .user { color:#ffe; margin-left:6px; }

/* HERO */
.hero {
  background:#120407;
  text-align:center;
  padding:40px 20px;
  color:#fff;
}

/*  CARRUSEL — MÁS PEQUEÑO, SIN PIXELEAR */
.carousel-wrap {
  width:100%;
  max-width:800px; /* más pequeño y nítido */
  margin:32px auto;
  overflow:hidden;
  border-radius:14px;
  background:#000;
  position:relative;
  aspect-ratio: 16 / 10; /* altura controlada */
}
.carousel-track {
  display:flex;
  height:100%;
  transition: transform 0.6s ease;
}
.carousel-slide {
  min-width:100%;
  height:100%;
}
.carousel-slide img {
  width:100%;
  height:100%;
  object-fit:contain; /*  NO recorta ni pixelea */
  display:block;
}

/* BOTONES */
.carousel-control {
  position:absolute;
  top:50%;
  transform:translateY(-50%);
  background:rgba(0,0,0,0.45);
  color:white;
  border:none;
  padding:10px 14px;
  cursor:pointer;
  border-radius:6px;
}
.carousel-control.left { left:10px; }
.carousel-control.right { right:10px; }

/* DOTS */
.carousel-dots {
  position:absolute;
  bottom:10px;
  left:50%;
  transform:translateX(-50%);
  display:flex;
  gap:7px;
}
.carousel-dots button {
  width:11px;
  height:11px;
  border-radius:50%;
  border:none;
  background:rgba(255,255,255,0.45);
  cursor:pointer;
}
.carousel-dots button.active {
  background:#e6b6b6;
}

/* SECTION */
.section {
  text-align:center;
  padding:30px 20px;
}
.button {
  display:inline-block;
  padding:11px 18px;
  background:#6B0F0F;
  color:#fff;
  border-radius:8px;
  text-decoration:none;
  font-weight:bold;
}
.button:hover { background:#9a1a2a; }
</style>
</head>

<body>

<!-- BOTÓN FLOTANTE SOLO SI NO HA INICIADO SESIÓN -->
<?php if(!isset($_SESSION['usuario'])): ?>
  <a class="login-floating" href="auth/login.php">Ingresar</a>
<?php endif; ?>

<nav>
  <a href="index.php">Inicio</a>

  <?php if(!isset($_SESSION['usuario'])): ?>
    <!-- Login ya está arriba, así que NO repetimos aquí -->
  <?php else: ?>
    <?php if($_SESSION['rol'] === 'admin'): ?>
      <a href="productos/index.php">Panel Admin</a>
    <?php endif; ?>
    <a href="menu.php">Menú</a>
    <a href="auth/logout.php">Cerrar sesión</a>
    <span class="user"><?= htmlspecialchars($_SESSION['usuario'])." (".$_SESSION['rol'].")" ?></span>
  <?php endif; ?>
</nav>

<div class="hero">
  <h1 style="margin:0;font-size:42px;">MoonBar 🍷🌙</h1>
  <p style="margin-top:6px;color:#ddd;">El lugar perfecto para disfrutar bebidas, sabores y buena energía </p>
</div>

<!--CARRUSEL -->
<div class="carousel-wrap">
  <div class="carousel-track" id="carouselTrack">
    <div class="carousel-slide"><img src="img/marga.jpg "alt="deliciosa bebida"></div>
    <div class="carousel-slide"><img src="img/moji.jpg" alt="fusion de sabores unicos"></div>
    <div class="carousel-slide"><img src="img/juli.jpg" alt="fuerte para los mejores"></div>
    <div class="carousel-slide"><img src="img/moon.jpg" alt="rica y unica solo en moonbar"></div>
    <div class="carousel-slide"><img src="img/club.jpg" alt="refrescante para un dia cualquiera"></div>
    <div class="carousel-slide"><img src="img/alitas.jpg" alt="tan picantes que solo es para los capaces"></div>
  </div>

  <button class="carousel-control left" id="prevBtn">&lsaquo;</button>
  <button class="carousel-control right" id="nextBtn">&rsaquo;</button>

  <div class="carousel-dots" id="dots"></div>
</div>

<script>
const track = document.getElementById('carouselTrack');
const slides = Array.from(track.children);
const dotsC = document.getElementById('dots');
let index = 0;
const total = slides.length;

/* crear dots */
slides.forEach((_,i)=>{
  const b = document.createElement('button');
  if(i===0) b.classList.add('active');
  b.addEventListener('click',()=>goTo(i));
  dotsC.appendChild(b);
});
const dots = [...dotsC.children];

function goTo(i){
  index = (i+total)%total;
  track.style.transform = `translateX(${-index * 100}%)`;
  dots.forEach((d,j)=>d.classList.toggle('active',j===index));
}

document.getElementById('nextBtn').onclick=()=>goTo(index+1);
document.getElementById('prevBtn').onclick=()=>goTo(index-1);

/* auto */
setInterval(()=>goTo(index+1), 3500);
</script>

</body>
</html>
