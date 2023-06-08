sendRequest = async (method, url, data, isJson = true) => {
    let request
    if (method === 'GET') {
        request = await fetch(url)
    }
    else {
        request = await fetch(url, {
            method: method,
            headers: {
                'Accept': 'application/json',
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
            },
            body: JSON.stringify(data)
        })
    }

    return isJson ? request.json() : request.text()
}

numberOnly = e => {
    e.target.value = e.target.value.replace(/[^0-9]/g, '').replace(/(\..*?)\..*/g, '$1')
}

currencyFormat = number => {
    const nf = new Intl.NumberFormat('en-US')
    return nf.format(number)
}
