"use strict"

let lista=[];

const contenedor_noticias=document.getElementById("contenidonoti");
const pag_sig=document.getElementById("posterior");
const pag_ant=document.getElementById("antes");


Inicio();

function cambiarPagina(eventos){
    eventos.preventDefault();
    Inicio(eventos.target.href);
}

async function Inicio(url_api="../php/noticiasLista.php"){
    const respuesta=await fetch(url_api);
    const datos=await respuesta.json();

    console.log(datos);

    lista=datos["datos"];

    if(datos["siguiente"]!=="null"){
        pag_sig.setAttribute("href","http://"+datos["siguiente"]);
        pag_sig.style.display="inline";
    }else{
        pag_sig.setAttribute("href","");
        pag_sig.style.display="none";
    }

    if(datos["anterior"]!=="null"){
        pag_ant.setAttribute("href","http://"+datos["anterior"]);
        pag_ant.style.display="inline";
    }else{
        pag_ant.setAttribute("href","");
        pag_ant.style.display="none";
    }

    renderizar(lista, contenedor_noticias, crearNoticia);
}

function renderizar(lista, contenedor_dom, creadorDom){
    contenedor_noticias.innerHTML="";
    lista.forEach(noticia=>{
        const noti=creadorDom(noticia);
        contenedor_dom.appendChild(noti);
    });
}

function crearNoticia(n){
    const noti=document.createElement("article");
    let fechanoticia=Date.parse(n.Fecha_publicacion);
    fechanoticia=new Date(fechanoticia);
    let dia=fechanoticia.getDate();
    let mes=fechanoticia.getMonth();
    let año=fechanoticia.getFullYear();
    let cont=n.Contenido;
    cont.substring(0,150);
    noti.innerHTML=`<article class='noti'>
    <div class='contenido_noticia'>
        <img src='${n.Imagen}'>
        <div>
        <p>${n.Titulo}</p>
        <p>${dia}-${mes}-${año}</p>
        </div>
        <p>${cont}</p>
        <a href='noti_completa.php?completa=${n.Id}'>VER MÁS</a>
    </div>
    </article>`;

    return noti;
}

pag_sig.addEventListener("click",cambiarPagina);
pag_ant.addEventListener("click",cambiarPagina);