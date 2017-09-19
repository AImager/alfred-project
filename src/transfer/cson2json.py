import sys, os, os.path, json, cson

file=open(sys.argv[1], 'rb')

obj=cson.load(file)

file.close()

file=open('./projects.json','w+')

file.write(json.dumps(obj))

file.close()


