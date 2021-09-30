// const keyPublishable = 'pk_test_Ittutiynv9WUFfCySlrkN4cu';
// const keySecret = 'sk_test_ah4KJHYcBCiTkrJrjP4gdiGS';	
const keyPublishable = 'pk_test_sJESCQSxFaq8wjW2rYrZLRaT';
const keySecret = 'sk_test_DlWf6AhPCkT0GZ8Hz8DOGV8p';   
const stripe = require("stripe")(keySecret);

app.post("/charge", function(req, res) {
 
    let amount = 5*100; // 500 cents means $5 
 
    // create a customer 
    stripe.customers.create({
        email: req.body.stripeEmail, // customer email, which user need to enter while making payment
        source: req.body.stripeToken // token for the given card 
    })
    .then(customer =>
        stripe.charges.create({ // charge the customer
        amount,
        description: "Sample Charge",
            currency: "usd",
            customer: customer.id
        }))
    .then(charge => res.render("charge")); // render the charge view: views/charge.pug
 
});
module.exports={
	
	initConnections: ()=>{

	}
}