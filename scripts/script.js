const profile = document.getElementById('profile');
const profileMenu = document.getElementsByClassName('profileMenu');
const signout = document.getElementById('signout');
const posts = document.getElementsByClassName('post');
const descInput = document.getElementById('descInput');
const charCounter = document.getElementById('charCounter');
const newPost = document.getElementsByClassName('newPost');
const searchBar = document.getElementById('searchBar');
const searchInputContainer = document.getElementById('search');
const searchResultsContainer = document.getElementById('searchResultsContainer');
const popularDay = document.getElementById("today");
const popularMonth = document.getElementById("thisMonth");
const popularYear = document.getElementById("thisYear");
const threadMenuBtn = document.getElementById('threadMenuBtn');
const threadsMenu = document.getElementById('threadsMenu');
const makePostFloatBtn = document.querySelector('main .make-post-float-btn');
if(document.body.clientWidth <= 320){
    makePostFloatBtn.style.display = 'block';
}
if(makePostFloatBtn){
    makePostFloatBtn.addEventListener('click', () =>{
        window.location.href = 'make-post.php'
    })
}

let profileMenuShow = false;
let threadMenuIsShow = false;
if(profile){
    profile.addEventListener('click', () =>{
        if(profileMenuShow){
            profileMenu[0].style.display = 'none'
            profileMenuShow = false;
        }else{
            profileMenu[0].style.display = 'flex'
            profileMenuShow = true;
        }
        
    })
    if(descInput){
        charCounter.textContent = parseInt(descInput.textContent.length);
        let counter = parseInt(descInput.textContent.length);
        descInput.addEventListener('keydown',(e) =>{
        if(e.key === 'Backspace'){
            if(counter > 0){
                counter--;
            }
        }else{
            if(e.key.length === 1){
                counter++;
            }
                     
        }
        charCounter.textContent = counter;
    })
    }
    
    signout.addEventListener('click', async() =>{
        const res = await axios.post('signout.php', 'signout=true');
        window.location.href = 'login.php';
    })
}
const foo = async (input) =>{
    const res = await axios.post('search.php', `search=${input}`);
    searchResultsContainer.innerHTML = "";
    if(input.trim() === "" || res.data.length === 0){
        searchResultsContainer.innerHTML = "";
        return;
    }
    res.data.map((post) =>{
        searchResultsContainer.innerHTML = searchResultsContainer.innerHTML + `<p>${post.title} </p>`
    })
}
if(searchBar){
    searchBar.addEventListener('input', () =>{
        foo(searchBar.value);
    })
    
    let searchBarIsActive = false;
    searchBar.addEventListener('click', () =>{
        if(!searchBarIsActive){
            searchInputContainer.style.boxShadow = '0px 3px 6px 0px rgba(0,0,0,0.75)';
            searchInputContainer.style.border = '1px solid #ccc';
            searchBarIsActive = true;
        }else{
            searchInputContainer.style.boxShadow = 'none';
            searchInputContainer.style.border = 'transparent';
            searchBarIsActive = false;
        }
    })
}

window.addEventListener('click', (e) =>{
    if(e.target.id !== 'searchBar' && searchBar){
        searchInputContainer.style.boxShadow = 'none';
        searchInputContainer.style.border = 'transparent';
        searchBarIsActive = false;
    }
    if(e.target.id !== 'profileIcon' && profile){
        profileMenu[0].style.display = 'none'
        profileMenuShow = false;
    }
    if(e.target.id !== 'threadMenuBtn'){
        threadsMenu.style.display = 'none';
        threadMenuIsShow = false;
    }
    
})
const postsList = [...posts];
postsList.forEach((post) => {
    post.addEventListener('click', (e) =>{
        window.location.href = `thread.php?id=${post.getAttribute('data-post-id')}`
    })
});

const newPostSection = [...newPost];

newPostSection.forEach((post) =>{
    post.addEventListener('click', () =>{
        window.location.href = `thread.php?id=${post.getAttribute('data-post-id')}`
    })
})
if(threadMenuBtn){
    threadMenuBtn.addEventListener('click', () =>{
        if(threadMenuIsShow){
            threadsMenu.style.display = 'none';
            threadMenuIsShow = false;
        }else{
            threadsMenu.style.display = 'flex';
            threadMenuIsShow = true;
        }
    })
    popularDay.addEventListener('click', async () =>{
        window.location.href = 'index.php?popular=day';
    })
    popularMonth.addEventListener('click', async () =>{
        window.location.href = 'index.php?popular=month';
    })
    popularYear.addEventListener('click', async () =>{
        window.location.href = 'index.php?popular=year';
    })
}



