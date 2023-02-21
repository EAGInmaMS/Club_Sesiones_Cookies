"use strict"

const actual=document.querySelector("#contenedor_actual");
const predi=document.querySelector("#contenedor_prediccion");
const frase=document.querySelector("#frase_perro");
let clima;
let datos_perro;
const pagina=document.querySelector("#page");
const sol=document.querySelector("#id-sun");
const luna=document.querySelector("#id-moon");

Inicio();

async function Inicio(){
    let peticion=`https://api.airvisual.com/v2/nearest_city?key=4363f25f-283b-41eb-9bc4-d4fbee638a4b`;
    const respuesta=await fetch(peticion);
    const datos= await respuesta.json();
    clima=datos.data;

    const respuesta_perro=await fetch(`https://dog-api.kinduff.com/api/facts`);
    const datosp=await respuesta_perro.json();
    datos_perro=datosp;

    console.log(datos_perro.facts);

    actual.appendChild(crearDom(clima.current.pollution.aqius,clima.current.weather.tp,clima.current.weather.hu));
    frase.appendChild(crearDom_perros(datos_perro.facts));
}

function crearDom(contaminacion,temperatura,humedad){
    const dom=document.createElement("tr");

    dom.innerHTML=`<td>${contaminacion}</td><td>${temperatura}ºC</td><td>${humedad}</td></tr>`;

    return dom;
}

function crearDom_perros(frase){
    const dom=document.createElement("h2");

    dom.innerHTML=`<h2>${frase}<h2>`;

    return dom;
}

const modo=localStorage.getItem("modo");
if(modo==="dia" || modo===null){
    pagina.classList.remove('bodyprodserv');
    luna.classList.remove('active');
    sol.classList.add('active');
}else{
    pagina.classList.add('bodyprodserv');
    luna.classList.add('active');
    sol.classList.remove('active');
}

sol.addEventListener("click" ,()=>{
    pagina.classList.remove('bodyprodserv');
    luna.classList.remove('active');
    sol.classList.add('active');
    localStorage.setItem("modo","dia");
});

luna.addEventListener("click" ,()=>{
    pagina.classList.add('bodyprodserv');
    luna.classList.add('active');
    sol.classList.remove('active');
    localStorage.setItem("modo","noche");
});