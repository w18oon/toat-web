export function extractDataFormEvent(event) {
    let vv = [...event.target.elements]
        .filter(ele => typeof ele['name'] !== 'undefined' && ele.name)
        .map(ele => [ele, ele.value, ele.name]);
    let form = {};
    for (let [ele, value] of vv) {
        form[ele.name] = value;
    }
    return form;
}

export function setAllObjectKeys(obj, val) {
    Object.keys(obj).forEach(function(index) {
        obj[index] = val;
    });
}

export function copyObject(object) {
    console.log(object);
    return JSON.parse(JSON.stringify(object));
}

export function warningBeforeUnload(callback) {
    if (typeof callback !== 'function') {
        callback = () => callback ? callback : null;
    }

    window.onbeforeunload = function () {
        let res = callback();
        if (!res) return null;
        if (typeof res === 'string') return res;
        return 'มีการเปลี่ยนแปลงข้อมูลโดยที่ยังไม่ได้บันทึก ต้องการออกจากหน้านี้?';
    };
}

export const DefaultDBRecord = {
    attribute1: null,
    attribute2: null,
    attribute3: null,
    attribute4: null,
    attribute5: null,
    attribute6: null,
    attribute7: null,
    attribute8: null,
    attribute9: null,
    attribute10: null,
    attribute11: null,
    attribute12: null,
    attribute13: null,
    attribute14: null,
    attribute15: null,
};
