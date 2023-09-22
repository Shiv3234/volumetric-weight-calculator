<!doctype html>
<html lang="en">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="csrf-token" content="{{ csrf_token() }}" />
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">

    <title>CalculatorWithAjex</title>
</head>
<style>
    .card-title {
        /* margin-bottom: 0.75rem; */
        margin-left: auto;
        color: #17a2b8;
        margin-top: 10px;
        margin-bottom: 10px;
        text-indent: -3%;
    }

    .volume-lable {
        color: #17a2b8;
    }

    .error {
        color: red;
    }

    p.label-class {
        margin-top: 37px;
        margin-bottom: 1rem;
        margin-left: -74px;
    }

    .check {
        display: flex;
        flex-direction: row;
        justify-content: space-evenly;
    }
</style>

<body>
    <div class="card" style="width: 50rem; margin-left: 30%; margin-top: 5%;">
        <!-- <div class="card-body"> -->
        <h5 class="card-title">Volumetric Weight Calculator</h5>
        <div class="card">
            <div class="card-body">
                <form>
                    <div class="check">
                        <div class="form-check">
                            <input class="form-check-input volume-radio" checked type="radio" name="volumeCm" id="inlineRadio1" onclick="myfunction()" value="kg" />
                            <label class="form-check-label" for="inlineRadio1">Kg(cm)</label>
                        </div>
                        <p class="label-class">(Length(cm)x Weight(cm)x Heigth(cm))/6000</p>

                        <div class="form-check">
                            <input class="form-check-input volume-radio" type="radio" name="volumeCm" id="inlineRadio2" onclick="myfunction()" value="lb" />
                            <label class="form-check-label" for="inlineRadio2">Lbs(inch)</label>
                        </div>
                        <p class="label-class">(Length(inchs)x Weight(inchs)x Heigth(inchs))/166</p>
                    </div>
                    <div class="form-outline mb-2">
                        Length: <input type="text" id="length" name="length" class="form-control" onkeypress="return /[0-9.]/i.test(event.key)">
                    </div>
                    <span class="length error"></span>

                    <div class="form-outline mb-2">
                        Width: <input type="text" id="width" name="width" class="form-control" onkeypress="return /[0-9.]/i.test(event.key)">
                    </div>
                    <span class="width error"></span>

                    <div class="form-outline mb-2">
                        Heigth: <input type="text" name="heigth" id="heigth" class="form-control" onkeypress="return /[0-9.]/i.test(event.key)">
                    </div>
                    <span class="heigth error"></span>

                    <div class="form-outline mb-2">
                        Quantity: <input type="text" name="quantity" id="quantity" class="form-control" value=1 onkeypress="return /[0-9]/i.test(event.key)">
                    </div>
                    <span class="quantity error"></span>

                    <div class="form-outline mb-2 volume-lable">
                        Volume(Cm): <input type="text" id="volumeCm" value="" readonly>

                        Volume(Lbs): <input type="text" id="volumeLbs" value="" readonly>
                    </div>
                    <button type="button" class="btn btn-primary" onclick="myfunction()">Submit</button>
                </form>
            </div>
        </div>
    </div>
    </div>
    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.12.9/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/js/bootstrap.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    <script>
        function myfunction() {
            // Get the selected volume unit (kg or lb)
            var selectedUnit = $('input[name="volumeCm"]:checked').val();
            if (selectedUnit === "kg") {
                $('#volumeLbs').val('');
            } else {
                $('#volumeCm').val('');
            }

            var length = parseFloat($('#length').val());
            var width = parseFloat($('#width').val());
            var heigth = parseFloat($('#heigth').val());
            var quantity = parseInt($('#quantity').val());

            if (length == null || isNaN(length)) {
                $('#length').val(''); // Clear the input field
                $('.length').html('Please enter the length');
            }
            if (width == null || isNaN(width)) {
                $('#width').val(''); // Clear the input field
                $('.width').html('Please enter the width');
            }
            if (heigth == null || isNaN(heigth)) {
                $('#heigth').val(''); // Clear the input field
                $('.heigth').html('Please enter the heigth');
            }
            if (quantity == null || isNaN(quantity)) {
                $('#quantity').val(''); // Clear the input field
                $('.quantity').html('Please enter the quantity');
            }
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            var form_data = new FormData;
            form_data.append('selectedUnit', selectedUnit);
            form_data.append('length', length);
            form_data.append('width', width);
            form_data.append('heigth', heigth);
            form_data.append('quantity', quantity);
            $.ajax({
                url: "{{route('sub-calculator')}}",
                type: "POSt",
                data: form_data,
                cache: false,
                contentType: false,
                processData: false,
                success: function(response) {
                    console.log(response.data);
                    if (response.data.conversion_type === 'kg') {
                        $('#volumeCm').val(response.data.volume.toFixed(2));
                        $('#volumeLbs').val('');
                    } else if (response.data.conversion_type === 'lb') {
                        $('#volumeCm').val('');
                        $('#volumeLbs').val(response.data.volume.toFixed(2));
                    }
                }
            });
        }
    </script>

</body>

</html>