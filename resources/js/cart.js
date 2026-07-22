let stored_data = JSON.parse(localStorage.getItem('cart') || '[]');

async function fetch_product_data() {

    const response = await fetch('http://localhost:8000/get_products');
    const data = await response.json();

    return data;
}
const data = await fetch_product_data()

const new_data = stored_data.map(user => 
    data.find(product=> product.id == user.id)
)

function add_to_array() {
    stored_data.map((user, i) => {
        if (new_data[i]) {
            new_data[i].quantity = user.quantity;
        }
    });
}


function calc_total() {
    let total = 0
    for (let i of new_data) {
        let subtotal = i.quantity * i.price;
        total += subtotal;
    }
    return total
}

function change_val() {
    document.getElementById('to_server').innerHTML = stored_data.map((user, i) => `
    <input type="hidden" name="id-${i}" value="${user.id}">
    <input type="hidden" name="qty-${i}" value="${user.quantity}">
`).join('');
}


add_to_array()

document.getElementById('total').textContent = calc_total();

document.getElementById('show_all').innerHTML = new_data.map(user => `<p> <span>${user.name}</span>, price: <span>${user.price}</span> 
    <button id="minus-btn" data-id="${user.id}">-</button> <span id="count-${user.id}"> ${user.quantity} </span>
    <button id="plus-btn" data-id="${user.id}">+</button> </p> `).join('');

change_val();

document.getElementById('length').innerHTML = `<input type='hidden' name='length' value='${stored_data.length}'></input>`;

const plus_buttons = document.querySelectorAll('#plus-btn')

plus_buttons.forEach(button => {
    button.addEventListener('click', function () {
        
        const item = stored_data.find(user=> user.id == this.dataset.id);

        const updated_quantity = item.quantity + 1;

        item.quantity = updated_quantity;
        
        document.getElementById(`count-${item.id}`).textContent = updated_quantity

        localStorage.setItem('cart', JSON.stringify(stored_data));
        add_to_array();
        document.getElementById('total').textContent = calc_total();

        change_val();
    })
})

const minus_buttons = document.querySelectorAll('#minus-btn')

minus_buttons.forEach(button => {
    button.addEventListener('click', function () {

        const item = stored_data.find(user=> user.id == this.dataset.id);    // find the product using .find(), return object

        const updated_quantity = item.quantity - 1;

        document.getElementById(`count-${item.id}`).textContent = updated_quantity    // display the number in frontend

        if (updated_quantity <= 0) {
            button.disabled = true;
            stored_data = stored_data.filter(user=> user.id != item.id)       // filter() to show everything except the not equal one
            setTimeout(() => {
                window.location.reload();
            }, 500);
            
        } else {
            item.quantity = updated_quantity;      // item [object] change the quantity
        }

        localStorage.setItem('cart', JSON.stringify(stored_data));
        add_to_array();
        document.getElementById('total').textContent = calc_total();
        change_val();
       
    })
})

document.getElementById('clear_ls').addEventListener('click', async function clear() {
    localStorage.removeItem('cart');
})
