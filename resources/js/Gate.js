export default class Gate {

    constructor (user){
        this.user =user;
    }
    isAdmin(){
        return this.user.role === 'admin';
    }
    isEditor(){
        return this.user.role === 'editor';
    }
    isWriter(){
        return this.user.role === 'writer';
    }
}
