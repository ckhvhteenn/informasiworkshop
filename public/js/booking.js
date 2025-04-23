document.addEventListener('DOMContentLoaded', () => {
    // Elements
    const decrementButton = document.querySelector('#decrement');
    const incrementButton = document.querySelector('#increment');
    const countDisplay = document.querySelector('#quantity');
    const hiddenInput = document.querySelector('#quantity_input');
    const displayQuantity = document.getElementById('display_quantity');
    const priceDisplay = document.getElementById('sub_total');
    const taxDisplay = document.getElementById('tax');
    const totalPriceDisplay = document.getElementById('total_amount');
    const workshopPrice = document.getElementById('workshopPrice');
    const participantsSection = document.getElementById('Attendants-Section');

    // Constants
    const unitPrice = parseFloat(workshopPrice.value); // Convert to number
    const ppnRate = 0.11;

    function updatePaymentDetails(count) {
        const price = unitPrice * count;
        const ppn = Math.round(price * ppnRate);
        const totalPrice = price + ppn;

        displayQuantity.textContent = count;
        priceDisplay.textContent = `Rp ${price.toLocaleString('id-ID')}`;
        taxDisplay.textContent = `Rp ${ppn.toLocaleString('id-ID')}`;
        totalPriceDisplay.textContent = `Rp ${totalPrice.toLocaleString('id-ID')}`;
    }

    function addParticipant() {
        const participantCount = participantsSection.querySelectorAll('.attendant-wrapper').length;
        const newParticipantHTML = `
            <div class="attendant-wrapper flex flex-col gap-[10px]">
                <div id="Attendant-${participantCount + 1}" class="group/accordion peer flex flex-col rounded-2xl border border-[#E6E7EB] p-6 has-[.invalid]:text-aktiv-black has-[.invalid]:has-[:checked]:border-aktiv-red has-[.invalid]:border-aktiv-grey has-[.invalid]:has-[:checked]:text-aktiv-red transition-all duration-300">
                    <label class="relative flex items-center justify-between">
                        <p class="font-semibold text-lg leading-[27px]">Attendants ${participantCount + 1}</p>
                        <input type="checkbox" name="accodion" class="hidden">
                        <img src="{{asset('assets/images/icons/arrow-square-up.svg')}}" class="absolute right-0 top-1/2 transform -translate-y-1/2 w-6 h-6 transition-all duration-300 opacity-100 group-has-[:checked]/accordion:rotate-180 group-has-[.invalid]/accordion:group-has-[:checked]/accordion:opacity-0" alt="icon">
                        <img src="{{asset('assets/images/icons/arrow-square-down-red.svg')}}" class="absolute right-0 top-1/2 transform -translate-y-1/2 w-6 h-6 transition-all duration-300 opacity-0 group-has-[.invalid]/accordion:group-has-[:checked]/accordion:opacity-100" alt="icon">
                    </label>
                    <div class="accordion flex flex-col gap-6 mt-6 transition-all duration-300 group-has-[:checked]/accordion:!h-0 group-has-[:checked]/accordion:mt-0 overflow-y-hidden">
                        <hr class="border-[#E6E7EB]">
                        <label class="flex flex-col gap-4">
                            <p class="font-medium text-aktiv-grey">Full Name</p>
                            <div class="group input-wrapper flex items-center rounded-xl p-4 gap-2 bg-[#FBFBFB] overflow-hidden">
                                <img src="{{asset('assets/images/icons/profile-circle.svg')}}" class="w-6 h-6 flex shrink-0 group-focus-within:hidden group-has-[:valid]:hidden" alt="icon">
                                <img src="{{asset('assets/images/icons/profile-circle-black.svg')}}" class="w-6 h-6 shrink-0 hidden group-focus-within:flex group-has-[:valid]:flex" alt="icon">
                                <input type="text" name="participants[${participantCount}][name]" class="appearance-none bg-transparent w-full outline-none text-lg leading-[27px] font-semibold placeholder:font-medium placeholder:text-aktiv-grey" placeholder="Write your complete name" required>
                            </div>
                        </label>
                        <label class="flex flex-col gap-4">
                            <p class="font-medium text-aktiv-grey">Occupation</p>
                            <div class="group input-wrapper flex items-center rounded-xl p-4 gap-2 bg-[#FBFBFB] overflow-hidden">
                                <img src="{{asset('assets/images/icons/briefcase.svg')}}" class="w-6 h-6 flex shrink-0 group-focus-within:hidden group-has-[:valid]:hidden" alt="icon">
                                <img src="{{asset('assets/images/icons/briefcase-black.svg')}}" class="w-6 h-6 shrink-0 hidden group-focus-within:flex group-has-[:valid]:flex" alt="icon">
                                <input type="text" name="participants[${participantCount}][occupation]" class="appearance-none bg-transparent w-full outline-none text-lg leading-[27px] font-semibold placeholder:font-medium placeholder:text-aktiv-grey" placeholder="Attendant Status" required>
                            </div>
                        </label>
                        <label class="flex flex-col gap-4">
                            <p class="font-medium text-aktiv-grey">Email Address</p>
                            <div class="group input-wrapper flex items-center rounded-xl p-4 gap-2 bg-[#FBFBFB] overflow-hidden">
                                <img src="{{asset('assets/images/icons/sms.svg')}}" class="w-6 h-6 flex shrink-0 group-focus-within:hidden group-has-[:valid]:hidden" alt="icon">
                                <img src="{{asset('assets/images/icons/sms-black.svg')}}" class="w-6 h-6 shrink-0 hidden group-focus-within:flex group-has-[:valid]:flex" alt="icon">
                                <input type="email" name="participants[${participantCount}][email]" class="appearance-none bg-transparent w-full outline-none text-lg leading-[27px] font-semibold placeholder:font-medium placeholder:text-aktiv-grey" placeholder="Attendant Email Address" required>
                            </div>
                        </label>
                    </div>
                </div>
                <span class="hidden font-medium text-aktiv-red peer-has-[.invalid]:block">Please fill in the attendant's data before proceeding.</span>
            </div>
        `;
        participantsSection.insertAdjacentHTML('beforeend', newParticipantHTML);
    }

    function removeParticipant() {
        const participantCount = participantsSection.querySelectorAll('.attendant-wrapper').length;
        if (participantCount > 1) {
            participantsSection.removeChild(participantsSection.lastElementChild);
        }
    }

    // Event Listeners
    decrementButton.addEventListener('click', () => {
        let count = parseInt(countDisplay.textContent);
        if (count > 1) {
            count--;
            countDisplay.textContent = count;
            hiddenInput.value = count;
            removeParticipant();
            updatePaymentDetails(count);
        }
    });

    incrementButton.addEventListener('click', () => {
        let count = parseInt(countDisplay.textContent);
        count++;
        countDisplay.textContent = count;
        hiddenInput.value = count;
        addParticipant();
        updatePaymentDetails(count);
    });

    // Form Validation
    const form = document.getElementById('Form');
    form.addEventListener('submit', function(event) {
        let isValid = true;
        
        // Validate main form fields
        const requiredFields = ['name', 'phone', 'email'];
        requiredFields.forEach(field => {
            const input = document.getElementById(field);
            if (!input.value.trim()) {
                input.closest('.input-wrapper').classList.add('invalid');
                isValid = false;
            }
        });
        
        // Validate participant fields
        const participantInputs = document.querySelectorAll('[name^="participants["]');
        participantInputs.forEach(input => {
            if (!input.value.trim()) {
                input.closest('.input-wrapper').classList.add('invalid');
                isValid = false;
            }
        });
        
        if (!isValid) {
            event.preventDefault();
            alert('Please fill in all required fields');
        }
    });

    // Initialize
    updatePaymentDetails(parseInt(countDisplay.textContent));
});