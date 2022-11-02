import {articles, Article} from './moduls/article.mjs';
import {setNewBillCode, setSelectOptions,addArticleToBill,recover} from './moduls/DOMactions.mjs';


window.onload = () => {
    setNewBillCode();
    setSelectOptions(articles);
    addArticleToBill(articles);
    recover();
}