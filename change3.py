import json , re
from py2neo import Graph, Node, Relationship
import os
from pprint import pprint
from bson import json_util
import sys


graph = Graph(password="ankit")
# print("Connected to neo4j server")

id1 = sys.argv[1]
id2 = sys.argv[2]

query = """
match (n)-[r:SCORE]->(p) where n.id={n1} and p.id={n2} set r.val = r.val+1 return r.val
"""
data = graph.run(query, n1 = id1, n2 = id2)