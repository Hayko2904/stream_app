document.addEventListener('DOMContentLoaded', function() {
    // Card type detection function
    function detectCardType(number) {
        const patterns = {
            visa: /^4/,
            mastercard: /^5[1-5]/,
            amex: /^3[47]/,
            discover: /^6(?:011|5)/
        };

        for (const [type, pattern] of Object.entries(patterns)) {
            if (pattern.test(number)) {
                return type;
            }
        }
        return 'unknown';
    }

    // Luhn algorithm validation
    function validateLuhn(number) {
        let sum = 0;
        let isEven = false;
        
        // Remove spaces
        number = number.replace(/\s/g, '');
        
        // Loop through values starting from the rightmost
        for (let i = number.length - 1; i >= 0; i--) {
            let digit = parseInt(number[i]);
            
            if (isEven) {
                digit *= 2;
                if (digit > 9) {
                    digit -= 9;
                }
            }
            
            sum += digit;
            isEven = !isEven;
        }
        
        return (sum % 10) === 0;
    }

    // Card number formatting
    const cardNumberInput = document.querySelector('input[name="payment[creditCardNumber]"]');
    const cardTypeIcon = document.querySelector('.card-type-icon');
    if (cardNumberInput) {
        cardNumberInput.addEventListener('input', function(e) {
            // Remove all non-digit characters
            let value = e.target.value.replace(/\D/g, '');
            
            // Add space after every 4 digits
            value = value.replace(/(\d{4})(?=\d)/g, '$1 ');
            
            // Limit to 16 digits (19 characters with spaces)
            value = value.substring(0, 19);
            
            e.target.value = value;
            
            // Update card type icon
            const cardType = detectCardType(value);
            if (cardTypeIcon) {
                cardTypeIcon.className = `card-type-icon ${cardType}`;
            }
            
            // Validate length and Luhn algorithm
            if (value.length === 19 && validateLuhn(value)) {
                e.target.setCustomValidity('');
            } else {
                e.target.setCustomValidity('Please enter a valid 16-digit card number');
            }
        });

        // Handle paste event
        cardNumberInput.addEventListener('paste', function(e) {
            e.preventDefault();
            let pastedData = (e.clipboardData || window.clipboardData).getData('text');
            let value = pastedData.replace(/\D/g, '');
            value = value.replace(/(\d{4})(?=\d)/g, '$1 ');
            value = value.substring(0, 19);
            e.target.value = value;
            
            // Update card type icon
            const cardType = detectCardType(value);
            if (cardTypeIcon) {
                cardTypeIcon.className = `card-type-icon ${cardType}`;
            }
            
            // Validate length and Luhn algorithm
            if (value.length === 19 && validateLuhn(value)) {
                e.target.setCustomValidity('');
            } else {
                e.target.setCustomValidity('Please enter a valid 16-digit card number');
            }
        });
    }

    // CVV validation
    const cvvInput = document.querySelector('input[name="payment[cvv]"]');
    if (cvvInput) {
        cvvInput.addEventListener('input', function(e) {
            let value = e.target.value.replace(/\D/g, '');
            
            // Get card type to determine CVV length
            const cardNumber = cardNumberInput ? cardNumberInput.value.replace(/\s/g, '') : '';
            const cardType = detectCardType(cardNumber);
            
            // Set max length based on card type (3 for most cards, 4 for Amex)
            const maxLength = cardType === 'amex' ? 4 : 3;
            value = value.substring(0, maxLength);
            
            e.target.value = value;
            
            // Validate CVV length
            if (value.length === maxLength) {
                e.target.setCustomValidity('');
            } else {
                e.target.setCustomValidity(`Please enter a valid ${maxLength}-digit CVV`);
            }
        });
    }

    // Date autocomplete
    const dateInput = document.querySelector('input[name="payment[cardExpiration]"]');
    if (dateInput) {
        dateInput.addEventListener('input', function(e) {
            let value = e.target.value.replace(/\D/g, '');
            
            if (value.length >= 2) {
                const month = value.substring(0, 2);
                // Validate month (1-12)
                if (parseInt(month) > 12) {
                    value = '12' + value.substring(2);
                }
                // Add slash after month if we have more digits
                if (value.length > 2) {
                    value = value.substring(0, 2) + '/' + value.substring(2);
                }
            }
            
            // Limit to 5 characters (MM/YY format)
            value = value.substring(0, 5);
            e.target.value = value;
        });

        // Handle paste event for date
        dateInput.addEventListener('paste', function(e) {
            e.preventDefault();
            let pastedData = (e.clipboardData || window.clipboardData).getData('text');
            let value = pastedData.replace(/\D/g, '');
            
            if (value.length >= 2) {
                const month = value.substring(0, 2);
                if (parseInt(month) > 12) {
                    value = '12' + value.substring(2);
                }
                if (value.length > 2) {
                    value = value.substring(0, 2) + '/' + value.substring(2);
                }
            }
            
            value = value.substring(0, 5);
            e.target.value = value;
        });
    }
}); 