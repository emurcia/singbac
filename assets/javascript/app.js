$(document).on("ready", function() {
	$(".form_validation").validationEngine({
		onValidationComplete : function(form, status){
			if(status){
				objectData = $(form).serialize();
				$.post("../includes/planilla/guardar.php", objectData).done(function(data) {
					window.location.reload();
				});			
			}
		}
	});

	$(document).on("blur", ".diastrabajados, .horastrabajados", function (e) {
		var element = $(e.currentTarget), 
			price   = $(element).attr('data-price'),
			transition =  $(element).attr('data-transition'),
			parent  = element.parents("tr");

		if($.isNumeric($(element).val()) && $.trim($(element).val()))
			subTotal = ( $(element).val() * parseFloat(price) );
		else
			subTotal = 0
		$(parent).find(transition).text("$" + subTotal.toFixed(2))

		events.onShowTotal(parent);
	});
});

var events = {
	onShowTotal : function (element) {
		salarioA = ($(element).find(".salario_normal").text()),
		salarioB = ($(element).find(".salario_horas").text()),
		salarioC = parseFloat(salarioA.substring(1)) + parseFloat(salarioB.substring(1));		
		descuento = salarioC * 0.0625 + salarioC * 0.03;
		salarioTotal = salarioC - descuento;

		$(element).find(".salario_bruto").text( "$" + salarioC.toFixed(2) );
		$(element).find(".deduciones").text( "$" + descuento.toFixed(2) );
		$(element).find(".salario_neto").text( "$" + salarioTotal.toFixed(2) );

		events.onShowSubTotal();
	},
	onShowSubTotal : function () {
		var price = 0,
			element = $(".tableBackground");

		$(element).find("tbody > tr > td.salario_neto").each(function(index, element) {
			price += parseFloat($(element).text().substring(1));
		});

		$(element).find("tfoot > tr > td#totalEnd").text("$" + price.toFixed(2));
	}
}