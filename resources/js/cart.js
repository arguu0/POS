
function count_total(stored_data) {
    let total = 0
    for (let i of stored_data) {
        let sum = i.quantity
        total += sum
    }
    return total
}

function change_subtotal(data, stored_data) {
    let total = 0;
    data.map((item,i) => {
        total += item.selling_price * stored_data[i].quantity;
    })

    document.getElementById('subtotal').innerText = total + "Ks";

    document.getElementById('total').innerText = total + 'KS';

    return total;
}

window.addEventListener('livewire:navigated', async function () {
    if (window.location.pathname == '/checkout') {
        let stored_data = JSON.parse(localStorage.getItem('cart') || '[]');
        let lS_data = stored_data.map(item => { return {id:item.id, quantity: item.quantity} });

        const response = await fetch("http://localhost:8000/post", {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json', 
            },
            body: JSON.stringify({ lS_data }),
        });
        let data = await response.json();

        change_subtotal(data, stored_data);

        const cart_list = document.getElementById(('cart_list'));
        if (!cart_list) return;
        cart_list.innerHTML = data.map((item,i) => `
            <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-3 p-4 bg-[#262626] rounded-lg border border-[#333333]">
                <div>
                    <h3 class="font-semibold text-sm">${item.name}</h3>
                    <span class="text-xs text-gray-400">${item.selling_price} Ks / unit</span>
                </div>
                <div class="flex items-center justify-between sm:justify-end gap-4">
                    <div class="flex items-center gap-2 bg-[#1a1a1a] px-2 py-1 rounded-md border border-[#383838]">
                        <button class="px-2 text-gray-400 hover:text-white" data-id="${item.id}" id='sub-btn'>-</button>
                        <span class="text-sm px-1 font-semibold" id="${item.id}">${stored_data[i].quantity}</span>
                        <button class="px-2 text-gray-400 hover:text-white" data-id="${item.id}" id='add-btn'>+</button>
                    </div>
                    <span class="text-sm font-semibold sm:w-20 sm:text-right" id='subtotal-${item.id}'>${item.selling_price * stored_data[i].quantity} Ks</span>
                    <button class="text-gray-500 hover:text-red-400 p-1" data-id='${item.id}' id='rm-from-cart'>✕</button>
                </div>
            </div>`).join('');

        const addition_btns = document.querySelectorAll('#add-btn')
        if (!addition_btns) return;
        addition_btns.forEach(button => {
            button.addEventListener('click', function () {
                let qty = stored_data.find(item=> item.id == this.dataset.id).quantity + 1;
                const id = this.dataset.id;
                const price = data.find(item=> item.id == id).selling_price;

                document.getElementById(id).innerText = qty;
                document.getElementById(`subtotal-${id}`).innerText = `${price * qty} Ks`;
                stored_data = stored_data.map(item=> {
                    if (item.id == this.dataset.id) {
                        return ({...item, quantity: qty  }) 
                    }
                    return item
                })
                localStorage.setItem('cart', JSON.stringify(stored_data));
                change_subtotal(data, stored_data);
                
                window.dispatchEvent(new CustomEvent('cart-updated', { 
                    detail: { count: count_total(stored_data) } 
                }));
            })
        })

        const subtract_btns = document.querySelectorAll('#sub-btn')
        if (!subtract_btns) return;
        subtract_btns.forEach(button => {
            button.addEventListener('click', function () {
                let qty = stored_data.find(item=> item.id == this.dataset.id).quantity - 1;
                const id = this.dataset.id;
                const price = data.find(item=> item.id == id).selling_price;

                document.getElementById(id).innerText = qty;
                document.getElementById(`subtotal-${id}`).innerText = `${price * qty} Ks`;
                if (qty <= 0) {
                    button.disabled = true;
                    stored_data = stored_data.filter(item=> item.id !== this.dataset.id)
                    location.reload();
                    if (stored_data.length == 0) return localStorage.removeItem('cart');
                } else {
                    stored_data = stored_data.map(item=> {
                        if (item.id == this.dataset.id) {
                            return ({...item, quantity: qty  }) 
                        }
                        return item
                    })
                }
                localStorage.setItem('cart', JSON.stringify(stored_data))
                change_subtotal(data, stored_data);

                window.dispatchEvent(new CustomEvent('cart-updated', { 
                    detail: { count: count_total(stored_data) } 
                }));
            })
        })

        const clear_item = document.querySelectorAll('#rm-from-cart');
        clear_item.forEach(button => {
            button.addEventListener('click', function() {
                stored_data = stored_data.filter(item => item.id !== this.dataset.id);

                localStorage.setItem('cart', JSON.stringify(stored_data))
                location.reload();
                if (stored_data.length == 0) return localStorage.removeItem('cart');
            })
        })

        document.getElementById('clear_all_btn').addEventListener('click', function () {
            localStorage.removeItem('cart');
            location.reload();
            if (stored_data.length == 0) return localStorage.removeItem('cart');
        })

        const input_discount = document.querySelector('#discount');
        input_discount.addEventListener('input', (event) => {
            let discount = event.target.value;
            document.getElementById('discount-value').innerText = discount + 'KS';
            document.getElementById('total').innerText = `${change_subtotal(data, stored_data) - discount} Ks`;
            
            document.getElementById('changes').innerText = parseInt(document.getElementById('paid_amount').value) - parseInt(document.getElementById('total').textContent) + ' Ks';
        })

        const input = document.querySelector('#paid_amount');
        input.addEventListener('input', (event) => {
            const total = parseInt(document.getElementById('total').textContent);
            let paid_amount = event.target.value;
            document.getElementById('changes').innerText = `${paid_amount - total} Ks`;
        })

        document.getElementById('pay_print').addEventListener('click', async function () {
            
            if (!JSON.parse(localStorage.getItem('cart'))) {
                alert("cart is empty");
                return;
            }
            
            const paid_amount = document.getElementById('paid_amount').value;
            const discount = document.getElementById('discount').value;

            if (!paid_amount) alert("Please enter paid amount!");

            else {
                let choice = confirm('Click "OK" to Confirm!');
                if (!choice) return;

                let get_ls = stored_data.map(item => { return { id: item.id, quantity: item.quantity } });
                let final_ls = {...get_ls, "paid": paid_amount, "discount": discount};
                
                const response = await fetch("http://localhost:8000/make_receipt", {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json'
                    },
                    body: JSON.stringify({ final_ls }),
                });
                let data = await response.json();

                window.location.pathname = `/transaction/${data}`;
                localStorage.removeItem('cart');
            }
        })
    }
})



    


