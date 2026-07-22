
let data = JSON.parse(localStorage.getItem('cart') || '[]');

function count_total() {
    let total = 0
    for (let i of data) {
        let sum = i.quantity
        total += sum
    }
    return total
}

document.getElementById('cart-counter').innerText = count_total()

const buttons = document.querySelectorAll('#add_to_cart_btn');

buttons.forEach(button => {
    button.addEventListener('click', function () {
        let values = {
            id: this.dataset.id,
            quantity: (JSON.parse(localStorage.getItem('cart'))?.find(product => product.id === this.dataset.id)?.quantity) ?? 1
        };
        
        const exist = data.some(user => user.id == values.id) 

        if (exist) {
            data = data.map(user=> {        // using .map() to loop through the data[localStorage] then return the value [object] back 
                if (user.id == values.id) {
                    const new_quantity = values.quantity + 1;

                    return {...user, quantity: new_quantity };
                }
                return user;
            })
            localStorage.setItem('cart', JSON.stringify(data))
            
        } else {
            data.push(values);

            localStorage.setItem('cart', JSON.stringify(data));
        }
        
        document.getElementById('cart-counter').textContent = count_total()
    })
});


