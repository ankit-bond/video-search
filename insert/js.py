import json , re
from datetime import datetime
from os import listdir
from os.path import isfile, join
from py2neo import Node , Relationship , Graph


mypath = 'test' # Path to all the json files . This directory should contain only the 500 json files
g = Graph(password = "ankit") # password for database . Username is assumed to be neo4j
tx = g.begin()
no_nodes = 500

# def secs(str) :
# 	str = str[0:10]
# 	a = datetime.strptime(str , "%Y-%m-%d")
# 	b = datetime(1970 , 1 , 1)
# 	return (a - b).total_seconds()

def common(a , b) :
	return list(set(a).intersection(set(b)))

def common_words(a , b) :
	return common(re.sub("[^'\w]" , " " , a).split() , re.sub("[^'\w]" , " " , b).split())

def get_node(f) :
	with open(join(mypath , f)) as data_file :
		data = json.load(data_file) 
	one = Node("Videos")
	for k in data['videoInfo']['statistics'] :
		one[k] = int(data['videoInfo']['statistics'][k])
	one['tags'] = data['videoInfo']['snippet'].get('tags' , [])
	one['channel_id'] = data['videoInfo']['snippet']['channelId']
	# one['published_at'] = secs(data['videoInfo']['snippet']['publishedAt'])
	one['thumbnail'] = data['videoInfo']['snippet']['thumbnails']['high']['url']
	one['kind'] = data['videoInfo']['kind']
	one['published_at'] = data['videoInfo']['snippet']['publishedAt']
	one['id'] = data['videoInfo']['id']
	one['etag'] = data['videoInfo']['etag']
	one['description'] = data['videoInfo']['snippet']['description']
	one['liveBroadcastContent'] = data['videoInfo']['snippet']['liveBroadcastContent']
	one['channelTitle'] = data['videoInfo']['snippet']['channelTitle']
	one['title'] = data['videoInfo']['snippet']['title']
	one['categoryId'] = int(data['videoInfo']['snippet']['categoryId'])
	return one 

onlyfiles = [f for f in listdir(mypath) if isfile(join(mypath, f))]
limit = onlyfiles[:no_nodes]

nodes = []
# creating nodes
for i in range(0 , no_nodes) :
	# print(str(i) + ' -- ' + limit[i])
	n = get_node(limit[i])
	tx.create(n)
	nodes.append(n)
# end

tx.commit()
# print('Finished nodes bruh . Starting relationships .')
tx = g.begin()

# creating relationships
for i in range(0 , no_nodes):
	tx.commit()
	tx = g.begin()
	for j in range(i + 1 , no_nodes) :
		common_tags = common(nodes[i]['tags'] , nodes[j]['tags'])
		common_wrds = common_words(nodes[i]['description'] , nodes[j]['description'])
		score = 9*len(common_tags) + 3*len(common_wrds)
		if len(common_tags) > 0 :
			tx.create(Relationship(nodes[i] , "COMMON_TAGS" , nodes[j] , common_tags = common_tags , no_common_tags = len(common_tags))) # common tags relationship
			tx.create(Relationship(nodes[j] , "COMMON_TAGS" , nodes[i] , common_tags = common_tags , no_common_tags = len(common_tags)))
			# print(str(i) + ' -- ' + str(j) + ' -- common tags')
		if nodes[i]['channel_id'] == nodes[j]['channel_id'] :
			score = score + 6
			tx.create(Relationship(nodes[i] , "SAME_CHANNEL" , nodes[j])) # same channel relationship
			tx.create(Relationship(nodes[j] , "SAME_CHANNEL" , nodes[i]))
			# print(str(i) + ' -- ' + str(j) + ' -- same channel')
		if len(common_wrds) > 0 :
			tx.create(Relationship(nodes[i] , "COMMON_DESC" , nodes[j] , common_words = common_wrds , no_common_words = len(common_wrds))) # common desc relationship
			tx.create(Relationship(nodes[j] , "COMMON_DESC" , nodes[i] , common_words = common_wrds , no_common_words = len(common_wrds)))

		if len(common_wrds) > 0 or len(common_tags) > 0:
			tx.create(Relationship(nodes[i] , "SCORE" , nodes[j] , val = score))
			tx.create(Relationship(nodes[j] , "SCORE" , nodes[i] , val = score))

			# print(str(i) + ' -- ' + str(j) + ' -- common desc')
		# print(str(i) + ' -- ' + str(j))
# end

# print('Committing')
tx.commit()
# print('Done bruh')
