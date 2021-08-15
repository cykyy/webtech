import os


def read_dict_from_file(file):
    """Reads dict from a json formatted file and returns the dict"""
    import json
    with open(os.path.abspath(os.path.dirname(__file__))+'/'+file) as f:
        data = f.read()
    js = json.loads(data)
    # print(json.dumps(js, indent=3))
    return js


def get_config(device=None):
    """
    :param device: takes string (e.g: 'mail').
    :return: returns settings as dict for parameterized device/platform type (e.g: 'mail') from conf.json file.
    """
    if device:
        conf = read_dict_from_file("config.json")
        d_conf = conf.get(device)
        return d_conf
    else:
        return
