const pizzas = [
  { id: 1, nombre: "Margarita", precio: 25000 },
  { id: 2, nombre: "Pepperoni", precio: 20000 },
  { id: 3, nombre: "Hawaiana", precio: 22000 },
  { id: 4, nombre: "Cuatro Quesos", precio: 28000 },
  { id: 5, nombre: "Vegetariana", precio: 24000 },
  { id: 6, nombre: "Pollo BBQ", precio: 26000 },
  { id: 7, nombre: "Mexicana", precio: 27000 },
  { id: 8, nombre: "Carbonara", precio: 29000 },
  { id: 9, nombre: "Napolitana", precio: 23000 },
  { id: 10, nombre: "Meat Lovers", precio: 30000 }
];


const select = document.querySelectorAll(".select");
const contenedor = document.querySelector('.pizzas');

const cargarOptionsEn = (selectElement) => {
  pizzas.forEach(pizza => {
    const option = document.createElement("option");
    option.value = `${pizza.nombre}|${pizza.precio}`;
    option.textContent = `${pizza.nombre} ($ ${pizza.precio})`;
    selectElement.appendChild(option);
  });
}

cargarOptionsEn(select[0])

document.querySelector('#btn').addEventListener('click', () => {


  const div = document.createElement("div");
  div.className = "grid grid-cols-1 md:grid-cols-2 gap-4 p-4 bg-red-50 rounded-xl shadow";

  const divSelect = document.createElement("div");
  divSelect.className = "flex flex-col";

  divSelect.innerHTML = `
    <label class="font-semibold mb-1">Tipo de pizza</label>
    <select name="arr[]" class="select p-2 rounded-lg border border-red-300 focus:ring-red-500" required>
      <option value="" disabled selected>Seleccionar tipo pizza</option>
    </select>
  `;

  const divCantidad = document.createElement("div");
  divCantidad.className = "flex flex-col";

  divCantidad.innerHTML = `
    <label class="font-semibold mb-1">Cantidad</label>
    <input type="number" name="cantidad[]" 
           class="p-2 rounded-lg border border-red-300 focus:ring-red-500" required>
  `;

  div.appendChild(divSelect);
  div.appendChild(divCantidad);
  contenedor.appendChild(div);

  const nuevoSelect = div.querySelector("select");
  cargarOptionsEn(nuevoSelect);
});

