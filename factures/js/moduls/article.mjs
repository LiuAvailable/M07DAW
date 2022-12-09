export class Article{
	constructor(codi, nom, preu){
		this.codi = codi;
		this.nom = nom;
		this.preu = preu;
	}
}

export let articles = [];
articles[0] = new Article('0001','patates','5');
articles[1] = new Article('0002','pomes','20');
articles[2] = new Article('0003','peres','8');
articles[3] = new Article('0004','espaguettis','22');
articles[4] = new Article('0005','macarrons','10');



