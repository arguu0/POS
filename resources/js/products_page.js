function count_total() {
    let data = JSON.parse(localStorage.getItem('cart') || '[]');
    let total = 0
    for (let i of data) {
        let sum = i.quantity
        total += sum
    }
    return total
}

document.addEventListener('DOMContentLoaded', () => {

    const buttons = document.querySelectorAll('#add_to_cart_btn');

    buttons.forEach(button => {
        button.addEventListener('click', function () {
            let data = JSON.parse(localStorage.getItem('cart') || '[]');
            
            let values = {
                id: this.dataset.id,
                // finding if id exists, if not set quantity as 1
                quantity: (JSON.parse(localStorage.getItem('cart'))?.find(product => product.id === this.dataset.id)?.quantity) ?? 1
            };
            
            const exist = data.some(user => user.id == values.id)

            if (exist) {
                data = data.map(user=> {        // using .map() to loop through the data(localStorage) then return the value [object] back 
                    if (user.id == values.id) {
                        const new_quantity = values.quantity + 1;

                        return {...user, quantity: new_quantity };
                    }
                    return user;
                })
                
            } else {
                data.push(values);
            }
            localStorage.setItem('cart', JSON.stringify(data));

            window.dispatchEvent(new CustomEvent('cart-updated', { 
                detail: { count: count_total() } 
            }));
        })  
    });

    const del_btns = document.querySelectorAll('#del-btn');
    del_btns.forEach(button => {
        button.addEventListener('click', function () {
            let data = JSON.parse(localStorage.getItem('cart') || '[]');
            data = data.filter(item=> item.id !== this.dataset.id)
            
            localStorage.setItem('cart', JSON.stringify(data));
            
        })
    })
})

let timer;
const search_input = document.querySelector('#search_bar');
search_input.addEventListener('input', function (event) {
   
    let search_value = event.target.value;
    if (search_value) clearTimeout(timer);
    else window.location.href = '/products';
   
    timer = setTimeout(() => {
        window.location.href = `/products?search=${search_value}`;
    }, 800);
})


